<?php

use App\Models\UserWorkOrder;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function getFullName($user)
{
    return ucwords($user->first_name . ' ' . $user->last_name);
}

function getImage($image, $isAvatar = false, $withBaseurl = false)
{
    $errorImage = $isAvatar ? url('/backend/no_avatar.png') : url('/backend/no_image.png');
    return !empty($image) ? ($withBaseurl ? url('/storage/' . $image) : Storage::url($image)) : $errorImage;
}

function saveResizeImage($file, $directory, $width, $height = null, $type = 'jpg')
{
    if (!Storage::exists($directory)) {
        Storage::makeDirectory("$directory");
    }
    $is_preview = strpos($directory, 'previews') !== false;
    $filename = Str::random() . time() . '.' . $type;
    $path = "$directory/$filename";
    $img = \Image::make($file)->orientate()->encode($type, $is_preview ? 40 : 85)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    if ($width == $is_preview) {
        $img = $img->blur(60);
    }
    $resource = $img->stream()->detach();
    //add public
    Storage::disk('public')->put($path, $resource, 'public');
    return $path;
}

function saveDocument($file, $directory)
{
    if (!Storage::exists($directory)) {
        Storage::makeDirectory("$directory");
    }
    $filename = Str::random() . time() . '.' . $file->getClientOriginalExtension();
    Storage::disk('public')->putFileAs($directory, $file, $filename);
    return $path = $directory . '/' . $filename;
}

/**
 * @param $file
 * get files
 */
function getFiles($file_name)
{
    $file = empty($file_name) ? '' : url('/storage/' . $file_name);
    return empty($file) ? '' : $file;
}

function statusClasses($status)
{
    $class = '';
    switch ($status) {
        case 'active':
            $class = 'success';
            break;
        case 'in_stock':
            $class = 'success';
            break;
        case 'offen':
            $class = 'danger';
            break;
        case 'out_of_stock':
            $class = 'danger';
            break;
        case 'niedrig':
            $class = 'danger';
            break;
        case 'in bearbeitung':
            $class = 'warning';
            break;
        case 'mittel':
            $class = 'warning';
            break;
        case 'abgeschlossen':
            $class = 'success';
            break;
        case 'hoch':
            $class = 'success';
            break;
        case 'inactive':
            $class = 'danger';
            break;
        case 'pending':
            $class = 'warning';
            break;
        case 'minimum_reached':
            $class = 'warning';
            break;
    }
    return $class;
}

function fileStatus($status)
{
    $result = ['class' => '', 'text' => ''];

    switch ($status) {
        case 'warten_auf_freigabe':
            $result = ['class' => 'warning', 'text' => 'Warten auf Freigabe'];
            break;
        case 'freigegeben':
            $result = ['class' => 'success', 'text' => 'Freigegeben'];
            break;
        case 'abgelehnt':
            $result = ['class' => 'danger', 'text' => 'Abgelehnt'];
            break;
        default:
            $result = ['class' => 'secondary', 'text' => ucfirst($status)];
            break;
    }

    return $result;
}

function deleteFile($path)
{
    if (!empty($path) && file_exists('app/' . $path)) {
        unlink(storage_path('app/' . $path));
    }

    $storage_path = 'storage/' . $path;
    $public_path = public_path($storage_path);
    if (!empty($path) && file_exists($public_path)) {
        unlink($public_path);
    }
}

function addEllipsis($text, $max = 30)
{
    return strlen($text) > 30 ? mb_substr($text, 0, $max, "UTF-8") . "..." : $text;
}

function isValue($value)
{
    if ($value !== 'undefined' && $value !== null && !empty($value)) {
        return $value;
    } else {
        return 'N/A';
    }
}

function formatString($key, $reverse = false)
{
    if ($reverse) {
        return str_replace([' ', "'"], '_', strtolower($key));
    } else {
        return str_replace(['_', '-'], ' ', strtolower($key));
    }
}

function scheduleWorkOrder($workOrder, $type, $count)
{
    $schedulePeriod = $workOrder->schedule_period;

    if (strpos($schedulePeriod, ' to ') !== false) {
        [$startDate, $endDate] = explode(' to ', $schedulePeriod);
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        if ($type == "weekly") {
            $newStartDate = $startDate->copy()->addWeeks($count);
            $newEndDate = $endDate->copy()->addWeeks($count);
        }
        if ($type == "monthly") {
            $newStartDate = $startDate->copy()->addMonths($count);
            $newEndDate = $endDate->copy()->addMonths($count);
        }
        if ($type == "yearly") {
            $newStartDate = $startDate->copy()->addYears($count);
            $newEndDate = $endDate->copy()->addYears($count);
        }
        $newSchedulePeriod = $newStartDate->toDateString() . ' to ' . $newEndDate->toDateString();
    } else {
        $startDate = Carbon::parse($schedulePeriod);
        if ($type == "weekly") {
            $newStartDate = $startDate->copy()->addWeeks($count);
        }
        if ($type == "monthly") {
            $newStartDate = $startDate->copy()->addMonths($count);
        }
        if ($type == "yearly") {
            $newStartDate = $startDate->copy()->addYears($count);
        }
        $newSchedulePeriod = $newStartDate->toDateString();
    }

    createScheduledWorkOrder($workOrder, $newSchedulePeriod);
}

function createScheduledWorkOrder($workOrder, $schedulePeriod)
{
    $newWorkOrder = WorkOrder::create([
        'name' => $workOrder->name,
        'image_url' => $workOrder->image_url,
        'description' => $workOrder->description,
        'estimate_hour' => $workOrder->estimate_hour,
        'estimate_minute' => $workOrder->estimate_minute,
        'schedule_period_time' => $workOrder->schedule_period_time,
        'selected_time' => 'no',
        'schedule_period' => $schedulePeriod,
        'priority' => $workOrder->priority,
        'created_by' => $workOrder->created_by,
    ]);
    foreach ($workOrder->userWorkOrders as $userWorkOrder) {
        UserWorkOrder::create([
            'user_id' => $userWorkOrder->user_id,
            'work_order_id' => $newWorkOrder->id,
            'location_id' => $userWorkOrder->location_id,
            'machine_id' => $userWorkOrder->machine_id,
        ]);
    }
    
  
}