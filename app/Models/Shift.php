<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $table = 'shifts';
    protected $fillable = [
        'start_time', 'end_time'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
