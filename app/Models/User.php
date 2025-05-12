<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    const ROLE_ADMIN = 2;
    const ROLE_STAFF = 1;
    const ROLE_CLIENT = 0;
    public static function getDefaultPassword()
    {
        return Hash::make("12345678");
    }
         protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'birth_date',
        'account_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
