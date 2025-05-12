<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_Schedule extends Model
{
    use HasFactory;

    protected $table = 'work_schedules';

    protected $fillable = [
        'user_id', 'shift_id', 'work_day'
    ];

    public function concept()
    {
        return $this->belongsTo(Concept::class, 'concept_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function shift(){
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    // public function appointment(){
    //     return $this->belongsTo(Appointment::class, '');
    // }

}