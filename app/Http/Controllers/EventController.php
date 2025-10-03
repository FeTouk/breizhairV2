<?php

    namespace App\Http\Controllers;

    use App\Models\Event;
    use Illuminate\Http\Request;

    class EventController extends Controller
    {
        public function index()
        {
            $events = Event::where('event_date', '>=', now())->orderBy('event_date', 'asc')->get();
            return view('pages.events.index', compact('events'));
        }

        public function show(Event $event)
        {
            return view('pages.events.show', compact('event'));
        }
    }
    
