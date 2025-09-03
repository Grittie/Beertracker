<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leaderboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tab Selector -->
            <div class="flex space-x-4 mb-4">
                <a href="{{ route('leaderboard', ['tab' => 'current']) }}" 
                   class="{{ $tab === 'current' ? 'font-bold text-blue-700 border-b-2 border-blue-500' : '' }} px-4 py-2 text-gray-700">
                    Current
                </a>
                <a href="{{ route('leaderboard', ['tab' => 'year1']) }}" 
                   class="{{ $tab === 'year1' ? 'font-bold text-blue-700 border-b-2 border-blue-500' : '' }} px-4 py-2 text-gray-700">
                    Year 1
                </a>
                <a href="{{ route('leaderboard', ['tab' => 'year2']) }}" 
                   class="{{ $tab === 'year2' ? 'font-bold text-blue-700 border-b-2 border-blue-500' : '' }} px-4 py-2 text-gray-700">
                    Year 2
                </a>
                <a href="{{ route('leaderboard', ['tab' => 'year3']) }}" 
                   class="{{ $tab === 'year3' ? 'font-bold text-blue-700 border-b-2 border-blue-500' : '' }} px-4 py-2 text-gray-700">
                    Year 3
                </a>
            </div>

            <!-- Leaderboard Table -->
            <div>

                <div>
                    @if ($tab === 'current')
                        @include('leaderboard.current')
                    @elseif ($tab === 'year1')
                        @include('leaderboard.year1')
                    @elseif ($tab === 'year2')
                        @include('leaderboard.year2')
                    @elseif ($tab === 'year3')
                        @include('leaderboard.year3')
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
