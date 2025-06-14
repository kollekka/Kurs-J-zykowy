<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'duration',
        'date',
        'time',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            $maxOrder = Lesson::where('course_id', $lesson->course_id)->max('order');
            $lesson->order = $maxOrder + 1;
        });
    }
}
