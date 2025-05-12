<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    const STATUS_DEBT = 0;
    const STATUS_PAID = 1;

    protected $table = 'contracts';

    protected $fillable = [
        'appointment_id', 'role'
    ];
    public function appointments()
{
    return $this->hasOne(Appointment::class, 'appointment_id'); 
}
    public function appointment() {
        return $this->belongsTo(Appointment::class, 'appointment_id'); 
    }

}