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
        
        <!-- Additional Styles -->
        <style>
            .flash-message {
                animation: fadeOut 5s forwards;
                animation-delay: 3s;
            }
            @keyframes fadeOut {
                to { opacity: 0; height: 0; padding: 0; margin: 0; border: 0; }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8 flash-message">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                        <div class="flex justify-between items-center">
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-green-700 hover:text-green-900">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8 flash-message">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                        <div class="flex justify-between items-center">
                            <span>{{ session('error') }}</span>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-red-700 hover:text-red-900">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @hasSection('content')
                        @yield('content')
                    @else
                        {{ $slot ?? '' }}
                    @endif
                </div>
            </main>
        </div>

        <!-- Auto-dismiss flash messages -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const flashMessages = document.querySelectorAll('.flash-message');
                flashMessages.forEach(msg => {
                    setTimeout(() => {
                        msg.style.transition = 'all 0.5s ease';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500);
                    }, 3000);
                });
            });
        </script>
    </body>
</html>