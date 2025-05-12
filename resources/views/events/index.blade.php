{{-- resources/views/events/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ auth()->user()->role === 'admin' ? __('Events') : __('My Events') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (auth()->user()->role === 'user')
                <div class="mb-4">
                    <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Create New Event
                    </a>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($events->isEmpty())
                        <p class="text-gray-600">No events found.</p>
                    @else
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border">Title</th>
                                    <th class="px-4 py-2 border">Date</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $event->title }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}</td>
                                        <td class="border px-4 py-2 space-x-2">
                                            @if (auth()->user()->role === 'admin' || auth()->id() === $event->user_id)
                                                <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.events.edit' : 'events.edit', $event->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                                <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.events.destroy' : 'events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
