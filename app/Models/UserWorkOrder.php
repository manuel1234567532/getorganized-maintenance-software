<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkOrder extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'work_order_id', 'location_id', 'machine_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }
  

}
