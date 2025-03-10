<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sessions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <label for="session-date" class="block text-sm font-medium text-gray-700 mb-1">
                    Select Session Date:
                </label>
                <div class="relative" style="max-width: 9rem;">
                    <input type="text" id="session-date" name="session_date"
                           class="block w-full pl-10 pr-3 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                           placeholder="Select date"
                           value="{{ request('session_date') }}">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 9h10m-2 6h-6m9-9H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V11a2 2 0 00-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    flatpickr("#session-date", {
                        dateFormat: "Y-m-d",
                        defaultDate: "{{ request('session_date') ?? now()->toDateString() }}",
                        enable: @json($highlightDates),
                        onChange: function(selectedDates, dateStr) {
                            window.location.href = '?session_date=' + dateStr;
                        }
                    });
                });
            </script>

            @if (Auth::user()->administrator)
            <div class="mb-6">
                <form action="{{ route('sessions.add_user') }}" method="POST" class="flex items-center space-x-2">
                    @csrf
                    <label for="user-select" class="text-sm font-medium text-gray-700">Add User to Today's Session:</label>
                    <select name="user_id" id="user-select" class="border rounded-md p-2">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Confirm</button>
                </form>
            </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="table-auto w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-1/12">#</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-3/12">Name</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Arrival</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Pitchers</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">€ Spent</th>
                            @if (Auth::user()->administrator)
                                <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessionDetails as $key => $detail)
                            <tr class="hover:bg-gray-100">
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $key + 1 }}</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $detail->user->name }}</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $detail->check_in_time }}</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $detail->pitchers }}</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">€ {{ $detail->pitchers * 14 }}</td>
                                @if (Auth::user()->administrator)
                                    <td class="py-4 px-6 text-gray-700 border-b text-left">
                                        <form action="{{ route('sessions.update_pitchers', ['session' => $detail->session_id]) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="increment" class="bg-green-500 text-white px-2 py-1 rounded">+</button>
                                            <button type="submit" name="action" value="decrement" class="bg-red-500 text-white px-2 py-1 rounded">-</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 px-6 text-center text-gray-700 border-b">No session details available for this date.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>