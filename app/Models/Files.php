<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $fillable = [
        'uploaded_by',
        'file_name',
        'file_size',
        'file_path',
        'current_folder',
        'status',
    ];
}
