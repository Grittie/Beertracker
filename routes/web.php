<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberListController;
use App\Http\Controllers\DeviceInformationController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/api/getTopDrinkers', function () {
    $topDrinkers = DB::table('scores')
        ->join('users', 'scores.user_id', '=', 'users.id')
        ->select('users.name', DB::raw('SUM(scores.pitchers) as total_pitchers'))
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('total_pitchers')
        ->limit(5)
        ->get();

    return response()->json([
        'labels' => $topDrinkers->pluck('name'),
        'values' => $topDrinkers->pluck('total_pitchers'),
    ]);
});

Route::get('/api/getPitchersOverTime', function () {
    $pitchersOverTime = DB::table('drink_sessions')
        ->select(DB::raw("DATE(SessionDate) as date"), DB::raw("SUM(Pitchers) as total_pitchers"))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return response()->json([
        'labels' => $pitchersOverTime->pluck('date'),
        'values' => $pitchersOverTime->pluck('total_pitchers'),
    ]);
});


Route::get('/guest_dashboard', function () { return view('guest-dashboard'); })->name('guest-dashboard');
Route::get('/guest_leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'index'])->name('guest-leaderboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/todo', function () { return view('to-do'); })->name('to-do');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/leaderboard/current', [LeaderboardController::class, 'showCurrent'])->name('leaderboard.current');
    Route::get('/leaderboard/year1', [LeaderboardController::class, 'showYear1'])->name('leaderboard.year1');
    Route::get('/leaderboard/year2', [LeaderboardController::class, 'showYear2'])->name('leaderboard.year2');
    Route::get('/sessions', [\App\Http\Controllers\SessionController::class, 'index'])->name('sessions');
    Route::get('/shame', function () { return view('hall-of-shame'); })->name('hall-of-shame');
});

Route::middleware('admin')->group(function () {
    // Routes or controller actions that require administrator privileges
    Route::get('score-registration', [\App\Http\Controllers\ScoreController::class, 'index'])->name('score-registration');
    Route::get('/memberlist', [\App\Http\Controllers\MemberListController::class, 'index'])->name('memberlist');
    Route::put('/memberlist/{id}', [MemberListController::class, 'update'])->name('memberlist.update');
    Route::delete('/memberlist/{user}', [MemberListController::class, 'destroy'])->name('memberlist.destroy');
    Route::post('store-score', [\App\Http\Controllers\ScoreController::class, 'store'])->name('score-store');
    Route::get('/device-information', [\App\Http\Controllers\DeviceInformationController::class, 'index'])->name('device-information');
    Route::post('/sessions/add-user', [\App\Http\Controllers\SessionController::class, 'addUserToSession'])->name('sessions.add_user');
    Route::put('/sessions/{session}/update-pitchers', [\App\Http\Controllers\SessionController::class, 'updatePitchers'])
    ->name('sessions.update_pitchers');

});

