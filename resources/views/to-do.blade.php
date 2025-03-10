<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About BeerTracker & To-Do') }}
        </h2>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Version: 1.0.2
        </p>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Created and maintained by Lars Grit. For feature requests or issues, contact me on your favorite messaging app.
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

            <div class="container mx-auto py-6 px-4">
                <!-- About BeerTracker -->
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">What is BeerTracker?</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Beertracker is the beertracking (in pitchers) website created by Lars Grit, drunkenly in Fest in 2023. Beertracker is designed to keep track of who orders when and how many pitchers of beer. It is a fun way to keep track of who is pitching in enough and who is not. Using beertracker avoids having to send tikkies and doing real hard calculations to keep the drinking fair.
                </p>

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mt-2">
                    With the current functionality implemented, I am watching for bugs and am focussing on implementing more fun features. If you have any ideas, feel free to reach out!
                </p>

                <!-- To-Do List -->
                <h2 class="mt-6 text-lg font-semibold text-gray-900 dark:text-white">To-Do List:</h2>
                <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                    <li>Group logic</li>
                    <li> Big rebranding</li>
                    <li> Wheel of Fortune</li>
                    <li> BeertrackerHUB breathalyzer</li>
                    <li> Personal statistics in profile page</li>
                    <li> Commands in the sessions</li>
                    <li> MVP screen in the sessions</li>
                    <li> Wall of shame post board</li>
                    <li> Food leaderboard</li>
                    <li> Feature request page</li>
                    <li> Beerchatters messaging board</li>
                    <li> Beertracker app</li>

                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
