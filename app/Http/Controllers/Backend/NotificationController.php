<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\Notifications;
use Dompdf\Dompdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
public function markAsRead($id)
{
    $notification = Notifications::find($id);
    if($notification) {
        $notification->status = 'read';
        $notification->save();
        return response()->json(['success' => '']);
    }
    return response()->json(['error' => 'Notification not found'], 404);
}

}