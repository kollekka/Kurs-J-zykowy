<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Instructor;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
}

