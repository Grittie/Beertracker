<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Leaderboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Table for Leaderboard -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="table-auto w-full border-collapse bg-white">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-1/12">#</th>
                        <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-3/12">Name</th>
                        <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Pitchers</th>
                        <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Liters</th>
                        <th class="py-4 px-6 font-semibold text-gray-700 border-b text-left w-2/12">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 0; @endphp
                    @foreach ($users as $key => $user)
                        @if (($user->scoresy3->pitchers ?? 0) > 0)
                            @php $rank++; @endphp
                            <tr class="hover:bg-gray-100">
                                <td class="py-4 px-6 text-gray-700 border-b text-left">
                                    @if ($rank == 1) 🥇
                                    @elseif ($rank == 2) 🥈
                                    @elseif ($rank == 3) 🥉
                                    @else {{ $rank }}
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $user->name }}</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $user->scoresy3->pitchers }}</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">{{ $user->scoresy3->pitchers * 1.8 }} L</td>
                                <td class="py-4 px-6 text-gray-700 border-b text-left">€ {{ $user->scoresy3->pitchers * 14 }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
