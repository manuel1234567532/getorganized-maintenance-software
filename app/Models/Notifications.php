<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_for',
        'created_date',
        'message',
        'status',
        'type',
    ];

    protected $dates = ['created_date'];
}
