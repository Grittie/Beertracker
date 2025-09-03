<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'pitchers',
        'shame_score',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function scores()
    {
        return $this->hasOne(Score::class);
    }

    public function scoresy1()
    {
        return $this->hasOne(ScoreY1::class, 'user_id');
    }

    public function scoresy2()
    {
        return $this->hasOne(ScoreY2::class, 'user_id');
    }

    public function scoresy3()
    {
        return $this->hasOne(ScoreY3::class, 'user_id');
    }

    public function card()
    {
        return $this->hasOne(Card::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
