<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'machine_type_id', 'status', 'location_name',
    ];

    public function machineType()
    {
        return $this->belongsTo(MachineType::class);
    }
}
