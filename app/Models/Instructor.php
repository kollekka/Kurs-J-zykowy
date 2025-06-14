<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Instructor extends Model
{
     use HasFactory;

    protected $fillable = ['full_name', 'email','bio'];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
