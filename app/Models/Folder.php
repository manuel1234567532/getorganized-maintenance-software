<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_name',
        'folder_type',
        'created_by',
        'created_date'
    ];

    // Annahme, dass Sie eine Beziehung zu einem User Model haben
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Hier können Sie weitere Methoden hinzufügen, falls Sie zusätzliche Beziehungen oder Funktionalitäten benötigen
}
