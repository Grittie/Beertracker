<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <h1 class="text-2xl font-medium text-gray-900">
        Welcome to Beertracker
    </h1>
    <p class="mt-4 text-gray-500 text-sm leading-relaxed">
        Beertracker is your go-to site for tracking the amount of beer everyone is pitching 😉 in for, without the hassle of tikkies 🍻
    </p>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            💦
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                All time liters of beer consumed
            </h2>
        </div>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            A total of {{ App\Models\Score::getTotalPitchers() }} pitchers have been drunk, resulting in {{ App\Models\Score::getTotalLiter() }} liters of beer having been consumed! 🥴
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            💸
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                All time money spent
            </h2>
        </div>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            A total of {{ App\Models\Score::getTotalPitchers() }} pitchers have been drunk, resulting in €{{ App\Models\Score::getTotalPrice() }},- having been spent on pitchers! 🥴
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            📊
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                Yearly stats
            </h2>
        </div>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Year 1: {{ DB::table('scoresy1')->sum('pitchers') }} pitchers, {{ DB::table('scoresy1')->sum('pitchers') * 1.8 }} liters, €{{ DB::table('scoresy1')->sum('pitchers') * 13 }},- <br>
            Year 2: {{ DB::table('scoresy2')->sum('pitchers') }} pitchers, {{ DB::table('scoresy2')->sum('pitchers') * 1.8 }} liters, €{{ DB::table('scoresy2')->sum('pitchers') * 14 }},- <br>
            Year 3: {{ DB::table('scoresy3')->sum('pitchers') }} pitchers, {{ DB::table('scoresy3')->sum('pitchers') * 1.8 }} liters, €{{ DB::table('scoresy3')->sum('pitchers') * 14 }},- <br>
            Current Year: {{ DB::table('scores')->sum('pitchers') }} pitchers, {{ DB::table('scores')->sum('pitchers') * 1.8 }} liters, €{{ DB::table('scores')->sum('pitchers') * 14 }},-
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            🏆
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                All-Time Top 3 Users
            </h2>
        </div>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            @php
                $allUsers = collect([
                    DB::table('scores')->join('users', 'scores.user_id', '=', 'users.id')
                        ->select('users.name', DB::raw('SUM(scores.pitchers) as total_pitchers'))
                        ->groupBy('users.id', 'users.name')
                        ->get(),
                    DB::table('scoresy1')->join('users', 'scoresy1.user_id', '=', 'users.id')
                        ->select('users.name', DB::raw('SUM(scoresy1.pitchers) as total_pitchers'))
                        ->groupBy('users.id', 'users.name')
                        ->get(),
                    DB::table('scoresy2')->join('users', 'scoresy2.user_id', '=', 'users.id')
                        ->select('users.name', DB::raw('SUM(scoresy2.pitchers) as total_pitchers'))
                        ->groupBy('users.id', 'users.name')
                        ->get(),
                    DB::table('scoresy3')->join('users', 'scoresy3.user_id', '=', 'users.id')
                        ->select('users.name', DB::raw('SUM(scoresy3.pitchers) as total_pitchers'))
                        ->groupBy('users.id', 'users.name')
                        ->get(),
                ])->flatten()->groupBy('name')
                  ->map(fn ($group) => $group->sum('total_pitchers'));

                $topUsers = $allUsers->sortDesc()->take(3);
                $lowestUser = $allUsers->filter(fn($pitchers) => $pitchers > 0)
                    ->sort()
                    ->take(1);
            @endphp

            @foreach ($topUsers as $name => $totalPitchers)
                {{ $loop->iteration }}. {{ $name }}: {{ $totalPitchers }} pitchers <br>
            @endforeach
            @foreach ($lowestUser as $name => $totalPitchers)
                4. {{ $name }}: {{ $totalPitchers }} pitchers <span style="font-weight:bold;font-style:italic;">lowest</span> <br>
            @endforeach
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            😤
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                Most Active Non-Pitchers
            </h2>
        </div>
        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            @php
                $mostActiveNonDrinker = DB::table('drink_sessions')
                    ->join('users', 'drink_sessions.user_id', '=', 'users.id')
                    ->select('users.name', DB::raw('COUNT(drink_sessions.session_id) as session_count'), DB::raw('SUM(drink_sessions.pitchers) as total_pitchers'))
                    ->groupBy('users.id', 'users.name')
                    ->havingRaw('SUM(drink_sessions.pitchers) <= ?', [1]) // Filter for users with minimal pitchers
                    ->orderBy('session_count', 'desc') // Most sessions attended
                    ->first();
            @endphp

            @if ($mostActiveNonDrinker)
                {{ $mostActiveNonDrinker->name }} has attended {{ $mostActiveNonDrinker->session_count }} sessions but only paid for {{ $mostActiveNonDrinker->total_pitchers }} pitchers!
            @else
                No data available yet.
            @endif
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
        🍺
        <h2 class="ml-3 text-xl font-semibold text-gray-900">
            Least Active, Most Pitchers
        </h2>
    </div>
    <p class="mt-4 text-gray-500 text-sm leading-relaxed">
        @php
            $leastActiveMostPitchers = DB::table('drink_sessions')
                ->join('users', 'drink_sessions.user_id', '=', 'users.id')
                ->select('users.name', DB::raw('COUNT(drink_sessions.session_id) as session_count'), DB::raw('SUM(drink_sessions.pitchers) as total_pitchers'))
                ->groupBy('users.id', 'users.name')
                ->havingRaw('COUNT(drink_sessions.session_id) > ?', [5]) // Filter for users with some activity
                ->orderByRaw('SUM(drink_sessions.pitchers) / COUNT(drink_sessions.session_id) DESC') // Most pitchers per session
                ->first();
        @endphp

        @if ($leastActiveMostPitchers)
            {{ $leastActiveMostPitchers->name }} has attended {{ $leastActiveMostPitchers->session_count }} sessions and pitched in for {{ $leastActiveMostPitchers->total_pitchers }} pitchers, averaging the most pitchers per session! 🍻
        @else
            No data available yet.
        @endif
    </p>
</div>


    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            📈
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                Pitchers Over Time (Sessions logic ERA)
            </h2>
        </div>
        <div class="mt-4" style="height: 300px;">
            <canvas id="pitcherChart"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("/api/pitchers-over-time")
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById("pitcherChart").getContext("2d");
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.dates,
                                datasets: [{
                                    label: "Pitchers Consumed",
                                    data: data.values.map(Number),
                                    borderColor: "#4CAF50",
                                    backgroundColor: "rgba(76, 175, 80, 0.2)",
                                    fill: true,
                                    tension: 0.3
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            });
        </script>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
            🍺
            <h2 class="ml-3 text-xl font-semibold text-gray-900">
                Top 5 Drinkers (Sessions logic ERA)
            </h2>
        </div>
        <div class="mt-4" style="height: 300px;">
            <canvas id="topDrinkersChart"></canvas>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("/api/top-drinkers")
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById("topDrinkersChart").getContext("2d");
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.names,
                                datasets: [{
                                    label: "Total Pitchers Consumed",
                                    data: data.values.map(Number),
                                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                                    borderColor: "rgba(255, 99, 132, 1)",
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            });
        </script>
    </div>
</div>
