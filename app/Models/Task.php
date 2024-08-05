<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'machine_id',
        'problem',
        'user_id',
        'priority_id',
        'status',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
