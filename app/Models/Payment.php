<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'amount',
        'payment_method',
        'status',
        'payment_date',
    ];
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
