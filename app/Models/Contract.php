<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    const STATUS_DEBT = 0; // dang no
    const STATUS_PAID = 1;  // da hoan thanh
    const SCALE_DEPOSIT = 0.3; // Tien coc
    const SCALE_DEBIT = 0.7;   // Tien no
    protected $table = 'contracts';
    protected $fillable = [
        'appointment_id',
        'role'
    ];


    public function appointments()
    {
        return $this->hasOne(Appointment::class, 'appointment_id');
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
