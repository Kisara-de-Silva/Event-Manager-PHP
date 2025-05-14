<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ auth()->user()->role === 'admin' ? __('All Events') : __('My Events') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                @if (auth()->user()->role === 'admin')
                    <div class="text-sm text-gray-600">
                        Showing all system events
                    </div>
                @else
                    <div class="text-sm text-gray-600">
                        Showing your events
                    </div>
                @endif
                
                <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Create New Event
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($events->isEmpty())
                        <p class="text-gray-600">No events found.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($events as $event)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}</td>
                                    @if(auth()->user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->user->name }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $event->event_date > now() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $event->event_date > now() ? 'Upcoming' : 'Past' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <form class="inline-block" action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
