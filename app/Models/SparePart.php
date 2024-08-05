<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_number',
        'spare_part_number',
        'image',
        'name_of_part',
        'supplier',
        'location_id',
        'minimum_stock',
        'price_per_piece',
        'total_price',
        'current_stock',
        'qr_code',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
