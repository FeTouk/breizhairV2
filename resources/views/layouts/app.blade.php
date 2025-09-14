<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- On initialise Alpine.js pour gérer l'état d'ouverture de la barre latérale --}}
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex bg-gray-100">
            
            <!-- Sidebar -->
            <aside 
                class="w-64 bg-white shadow-md fixed inset-y-0 left-0 transform lg:relative lg:translate-x-0 transition-transform duration-200 ease-in-out z-30"
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            >
                @include('layouts.navigation')
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center">
                            <!-- Hamburger Button (visible sur mobile) -->
                            <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden mr-4 text-gray-500 focus:outline-none">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            
                            <div class="flex-grow">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-grow p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
