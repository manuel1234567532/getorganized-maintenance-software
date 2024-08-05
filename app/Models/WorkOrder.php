<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image_url',
        'description',
        'estimate_hour',
        'estimate_minute',
        'schedule_period_time',
        'selected_time',
        'schedule_period',
        'priority',
        'status',
        'created_by',
        'no_of_repetitions',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userWorkOrders()
    {
        return $this->hasMany(UserWorkOrder::class);
    }
}
