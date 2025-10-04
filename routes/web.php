<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FlightReportController;
use App\Http\Controllers\IvaoApiController;
use App\Http\Controllers\FlightValidationController;
use App\Http\Controllers\PilotManagementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SkyVectorApiController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\Admin\RouteManagementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Routes Publiques (Visiteurs)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $activePilots = User::where('status', 'active')->count();
    $totalFlights = User::sum('total_flights');
    $totalFlightHours = floor(User::sum('total_flight_hours') / 60);
    $totalNauticalMiles = User::sum('total_nautical_miles');
    return view('welcome', [
        'activePilots' => $activePilots,
        'totalFlights' => $totalFlights,
        'totalFlightHours' => $totalFlightHours,
        'totalNauticalMiles' => $totalNauticalMiles,
    ]);
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/reglement', function () {
    return view('pages.reglement');
});

Route::get('/badges', function () {
    $badges = [
        ['image' => 'contributeur.png', 'name' => 'Contributeur', 'description' => 'Badge accordé aux personnes ayant contribué significativement à la compagnie.'],
        ['image' => 'badge-createur.png', 'name' => 'Créateur', 'description' => "Badge accordé aux pilotes créant du contenu en ligne mettant en avant Breizh'Air."],
        ['image' => 'badge-event-bzh.png', 'name' => "Evènements Breizh'Air", 'description' => "Badge attribué aux pilotes ayant participé à au moins 10 événements Breizh'Air."],
        ['image' => 'badge-event-ivao.png', 'name' => 'Evènements IVAO', 'description' => "Badge attribué aux pilotes ayant participé à 10 évènements IVAO avec la compagnie Breizh'Air."],
        ['image' => 'pole-event.png', 'name' => 'Pôle événement', 'description' => 'Badge accordé aux membres du pôle événement.'],
        ['image' => 'respo-event.png', 'name' => 'Responsable pôle événement', 'description' => 'Badge accordé au responsable du pôle événement.'],
        ['image' => 'pole-forma.png', 'name' => 'Pôle formation', 'description' => 'Badge accordé aux membres du pôle formation.'],
        ['image' => 'respo-forma.png', 'name' => 'Responsable pôle formation', 'description' => 'Badge accordé au responsable du pôle formation.'],
        ['image' => 'pole-pilote.png', 'name' => 'Pôle pilote', 'description' => 'Badge accordé aux membres du pôle pilote.'],
        ['image' => 'respo-pilote.png', 'name' => 'Responsable pôle pilote', 'description' => 'Badge accordé au responsable du pôle pilote.'],
        ['image' => 'fondateur.png', 'name' => 'Fondateur', 'description' => "Fondateur de Breizh'Air."],
        ['image' => 'pdg.png', 'name' => 'PDG', 'description' => "PDG de Breizh'Air."],
        ['image' => 'webmaster.png', 'name' => 'Webmaster', 'description' => "Webmaster de Breizh'Air."],
        ['image' => '50vols.png', 'name' => '50 vols', 'description' => "Badge accordé aux pilotes ayant effectué 50 vols avec Breizh'Air."],
        ['image' => '100vols.png', 'name' => '100 vols', 'description' => "Badge accordé aux pilotes ayant effectué 100 vols avec Breizh'Air."],
        ['image' => '200vols.png', 'name' => '200 vols', 'description' => "Badge accordé aux pilotes ayant effectué 200 vols avec Breizh'Air."],
    ];
    return view('pages.badges', ['badges' => $badges]);
});

Route::get('/staff', function () {
    return view('pages.staff');
});

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/evenements', [EventController::class, 'index'])->name('events.index');
Route::get('/evenements/{event:slug}', [EventController::class, 'show'])->name('events.show');


/*
|--------------------------------------------------------------------------
| Routes Protégées (Pilotes et Admins)
|--------------------------------------------------------------------------
*/

// Routes pour les pilotes ayant passé le test d'entrée
Route::middleware(['auth', 'verified', 'test.passed'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
    Route::post('/flight-report', [FlightReportController::class, 'store'])->name('flight-report.store');
    Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
});

// Routes pour les utilisateurs connectés (mais n'ayant pas forcément passé le test)
Route::middleware('auth')->group(function () {
    Route::get('/test-entree', [TestController::class, 'show'])->name('test.show');
    Route::post('/verif-test', [TestController::class, 'verify'])->name('test.verify');
    Route::get('/api/ivao/last-flight', [IvaoApiController::class, 'getLastFlight'])->name('api.ivao.last-flight');
    Route::get('/api/skyvector/distance', [SkyVectorApiController::class, 'getDistance'])->name('api.skyvector.distance');

    // Section réservée uniquement aux Administrateurs
    Route::middleware('admin')->group(function () {
        Route::resource('questions', QuestionController::class);
        Route::get('/admin/flights', [FlightValidationController::class, 'index'])->name('flights.validation.index');
        Route::get('/admin/flights/{flight}', [FlightValidationController::class, 'show'])->name('flights.validation.show');
        Route::patch('/admin/flights/{flight}', [FlightValidationController::class, 'update'])->name('flights.validation.update');
        
        // Routes de gestion des pilotes
        Route::resource('pilots', PilotManagementController::class)->except(['create', 'store']);
        Route::patch('/pilots/{pilot}/skycoins', [PilotManagementController::class, 'updateSkycoins'])->name('pilots.skycoins.update');
        
        // Routes de gestion des routes
        Route::resource('admin/routes', RouteManagementController::class)->names('admin.routes');
        Route::patch('/admin/routes/{route}/airac', [RouteManagementController::class, 'updateAirac'])->name('admin.routes.updateAirac');
        
        // Routes de gestion des événements
        Route::resource('admin/events', EventManagementController::class)->names('admin.events');
    });
});


/*
|--------------------------------------------------------------------------
| Routes d'Authentification
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';