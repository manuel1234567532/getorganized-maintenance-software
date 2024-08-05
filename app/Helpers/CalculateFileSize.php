<?php

namespace App\Helpers; // Namespace-Deklaration zuerst

use App\Models\Files;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CalculateFileSize
{
    public static function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function calculateTotalSize($fileSizes) {
        $totalBytes = 0;

        foreach ($fileSizes as $fileSize) {
            // Angenommen, fileSize ist bereits in Bytes
            $totalBytes += $fileSize->file_size;
        }

        // Formatieren der Gesamtgröße in lesbare Einheiten
        return self::formatSizeUnits($totalBytes);
    }
}