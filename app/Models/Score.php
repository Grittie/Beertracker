<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'pitchers',
        'shame',
        'user_id',
    ];

    // Define constants for magic numbers
    private const LITER_CONVERSION_FACTOR = 1.8;
    private const PRICE_PER_PITCHER = 14;

    /**
     * Get total pitchers for all users.
     */
    public static function getTotalPitchers()
    {
        $totalPitchers = DB::table('scores')->sum('pitchers')
            + DB::table('scoresy1')->sum('pitchers')
            + DB::table('scoresy3')->sum('pitchers')
            + DB::table('scoresy2')->sum('pitchers');
        return $totalPitchers;
    }

    /**
     * Get total liters for all users.
     */
    public static function getTotalLiter()
    {
        $totalPitchers = self::getTotalPitchers();
        return $totalPitchers * self::LITER_CONVERSION_FACTOR;
    }

    /**
     * Get total price for all pitchers.
     */
    public static function getTotalPrice()
    {
        $totalPitchers = self::getTotalPitchers();
        return $totalPitchers * self::PRICE_PER_PITCHER;
    }

    /**
     * Update the score for a user based on a session.
     * 
     * @param int $userId
     * @param int $pitchers
     */
    public static function updateUserScore(int $userId, int $pitchers)
    {
        $score = static::firstOrCreate(['user_id' => $userId]);
        $score->increment('pitchers', $pitchers);
    }

    /**
     * Decrease the user's score (e.g., if a session is updated).
     * 
     * @param int $userId
     * @param int $pitchers
     */
    public static function decreaseUserScore(int $userId, int $pitchers)
    {
        $score = static::where('user_id', $userId)->first();
        if ($score) {
            $score->decrement('pitchers', $pitchers);
        }
    }
}
