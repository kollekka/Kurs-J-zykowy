<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Instructor;

class Course extends Model
{

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'language',
        'level',
        'start_date',
        'end_date',
        'instructor_id',
        'price',
        'group_size',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
}

