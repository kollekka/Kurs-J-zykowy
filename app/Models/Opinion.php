<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $fillable = [
        'opinion',
        'rating',
        'user_id',
        'course_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
