<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    const STATUS_WAIT = 0;
    const STATUS_DONE = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_ASYNC = 3;
    // Thứ tự: 0--2--3--1

    protected $table = 'appointments';

    protected $fillable = [
        'user_id', 'staff_id', 'concept_id', 'shift',
        'work_day', 'note', 'reply', 'link_image',
        'status'
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
}