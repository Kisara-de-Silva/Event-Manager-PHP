<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Welcome, {{ Auth::user()->name }}!</h3>
                        <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Create New Event
                        </a>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-blue-800">Quick Stats</h4>
                        <p>Your upcoming events: {{ Auth::user()->events()->where('event_date', '>=', now())->count() }}</p>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-800 mb-2">Recent Events</h4>
                        <ul class="space-y-2">
                            @foreach(Auth::user()->events()->latest()->take(3)->get() as $event)
                            <li class="flex items-center justify-between p-2 hover:bg-gray-50">
                                <span>{{ $event->title }} ({{ $event->event_date->format('M d') }})</span>
                                <a href="{{ route('events.edit', $event) }}" class="text-sm text-blue-600">Edit</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
