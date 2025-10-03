<form action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($event))
        @method('PUT')
    @endif

    <div class="space-y-6">
        {{-- Champ Titre --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'événement</label>
            <input type="text" name="title" id="title" value="{{ old('title', $event->title ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Champ Date de l'événement --}}
        <div>
            <label for="event_date" class="block text-sm font-medium text-gray-700">Date et heure de l'événement</label>
            <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Champ Contenu --}}
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Description de l'événement</label>
            <textarea name="content" id="content" rows="10" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $event->content ?? '') }}</textarea>
        </div>

        {{-- Champ Image --}}
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image de l'événement (facultatif)</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @if(isset($event) && $event->image)
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Image actuelle :</p>
                    <div class="mt-2 p-2 border rounded-md bg-gray-50 inline-block">
                        {{-- 👇 MODIFICATION ICI : la hauteur maximale de l'image est réduite 👇 --}}
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement" class="max-h-32 w-auto rounded-md">
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 flex justify-end">
        <a href="{{ route('admin.events.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-4">Annuler</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            {{ isset($event) ? 'Mettre à jour' : 'Publier l\'événement' }}
        </button>
    </div>
</form>

