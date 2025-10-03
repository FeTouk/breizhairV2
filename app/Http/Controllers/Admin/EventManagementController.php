<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventManagementController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'event_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($validated);

        // 👇 MODIFICATION ICI 👇
        return redirect()->route('admin.events.index')->with('success', 'Événement créé avec succès.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'event_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            // Storage::disk('public')->delete($event->image);
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        // 👇 MODIFICATION ICI 👇
        return redirect()->route('admin.events.index')->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy(Event $event)
    {
        // Supprimer l'image associée
        // Storage::disk('public')->delete($event->image);
        $event->delete();
        
        // 👇 MODIFICATION ICI 👇
        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé avec succès.');
    }
}

