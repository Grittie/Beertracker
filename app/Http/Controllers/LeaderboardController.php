<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'current'); // Default to 'current'

        $users = match ($tab) {
            'year1' => User::select('users.*', 'scoresy1.pitchers')
                ->leftJoin('scoresy1', 'users.id', '=', 'scoresy1.user_id')
                ->orderByDesc('scoresy1.pitchers')
                ->get(),
            'year2' => User::select('users.*', 'scoresy2.pitchers')
                ->leftJoin('scoresy2', 'users.id', '=', 'scoresy2.user_id')
                ->orderByDesc('scoresy2.pitchers')
                ->get(),
            'year3' => User::select('users.*', 'scoresy3.pitchers')
                ->leftJoin('scoresy3', 'users.id', '=', 'scoresy3.user_id')
                ->orderByDesc('scoresy3.pitchers')
                ->get(),
            default => User::select('users.*', 'scores.pitchers')
                ->leftJoin('scores', 'users.id', '=', 'scores.user_id')
                ->orderByDesc('scores.pitchers')
                ->get(),
        };

        return view('leaderboard', compact('users', 'tab'));
    }


    public function showCurrent()
    {
        $users = User::with('scores')
            ->join('scores', 'users.id', '=', 'scores.user_id')
            ->orderByDesc('scores.pitchers')
            ->get(['users.*']);

        return view('leaderboard.current', compact('users'));
    }

    public function showYear1()
    {
        $users = User::with('scoresy1')
            ->join('scoresy1', 'users.id', '=', 'scoresy1.user_id')
            ->orderByDesc('scoresy1.pitchers')
            ->get(['users.*']);

        return view('leaderboard.year1', compact('users'));
    }

    public function showYear2()
    {
        $users = User::with('scoresy2')
            ->join('scoresy2', 'users.id', '=', 'scoresy2.user_id')
            ->orderByDesc('scoresy2.pitchers')
            ->get(['users.*']);

        return view('leaderboard.year2', compact('users'));
    }
}
