<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leaderboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="table-auto w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-1/12">#</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-3/12">Naam</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Pitchers</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Liter bier</th>
                            <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Prijskes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            @if ($user->scores->pitchers >= 1)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-4 px-6 text-gray-700 border-b text-left">
                                        @if ($key == 0) 🥇
                                        @elseif ($key == 1) 🥈
                                        @elseif ($key == 2) 🥉
                                        @else {{ $key + 1 }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $user->scores->pitchers }}</td>
                                    <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $user->scores->pitchers * 1.8 }} L</td>
                                    <td class="py-4 px-6 text-gray-700 border-b text-left">€ {{ $user->scores->pitchers * 13 }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
