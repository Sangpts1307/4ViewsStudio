<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    const PAID  = 1;
    const CONVERT_PAID_STATUS = [
        1 => 'Đã thanh toán',
        0 => 'Trả lương'
    ];
    protected $fillable = [
        'user_id', 'base_salary', 'total_shift', 'finished_shift',
        'total_salary', 'month', 'status'
    ];
}