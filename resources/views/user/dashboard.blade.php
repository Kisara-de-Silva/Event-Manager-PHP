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
                    <!-- Welcome Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Welcome, {{ $user->name }}!</h3>
                        <a href="{{ route('events.create') }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-150">
                            + Create New Event
                        </a>
                    </div>
                    
                    <!-- Stats Card -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-blue-800 mb-2">Quick Stats</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Events</p>
                                <p class="text-2xl font-semibold">{{ $user->events()->count() }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Upcoming Events</p>
                                <p class="text-2xl font-semibold">{{ $user->events()->where('event_date', '>=', now())->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Events Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-gray-800">Recent Events</h4>
                            <a href="{{ route('events.index') }}" class="text-sm text-blue-600 hover:underline">
                                View All
                            </a>
                        </div>
                        
                        @if($recentEvents->isEmpty())
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <p class="text-gray-500">No events found. Create your first event!</p>
                            </div>
                        @else
                            <ul class="space-y-3 divide-y divide-gray-100">
                                @foreach($recentEvents as $event)
                                <li class="pt-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">{{ $event->title }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $event->event_date->format('F j, Y') }}
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('events.edit', $event) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 text-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
