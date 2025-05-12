<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    protected $table = 'concepts';

    protected $fillable = [
        'name', 'price', 'short_content', 'content'
    ];

    public function mainImage()
    {
        return $this->hasOne(Image::class)->where('role', 0);
    }

    public function supportImages()
    {
        return $this->hasMany(Image::class)->where('role', 1);
    }
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }


}