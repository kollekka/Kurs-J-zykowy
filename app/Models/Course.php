<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory;

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

    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }

    // Nadchodzące kursy
    public static function upcoming()
    {
        return self::where('start_date', '>', Carbon::now())->orderBy('start_date', 'asc')->get();
    }

    // Minione kursy
    public static function past()
    {
        return self::where('end_date', '<', Carbon::now())->orderBy('end_date', 'desc')->get();
    }
}

