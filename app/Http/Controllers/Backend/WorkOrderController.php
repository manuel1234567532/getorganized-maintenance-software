<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Machine;
use App\Models\MachineType;
use App\Models\User;
use App\Models\UserWorkOrder;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Notifications;
class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loggedInUserId = Auth::id();
        $locations = Location::all();
        $machinesWithoutType = Machine::whereNull('machine_type_id')->get();
        $machineTypes = MachineType::with('machines')->get();
        $users = User::where('id', '!=', $loggedInUserId)->get();

        $userWOIds = UserWorkOrder::where('user_id', auth()->id())
                    ->distinct()
                    ->pluck('work_order_id')
                    ->toArray();
                
        $workOrders = WorkOrder::whereIn('id', $userWOIds)
                    ->orWhere('created_by', auth()->id())->get();

        $userWorkOrders = UserWorkOrder::whereIn('work_order_id', $workOrders->pluck('id'))->get();

        return view('backend.workorder.index', compact('users', 'locations', 'machinesWithoutType', 'machineTypes', 'workOrders', 'userWorkOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location_id' => 'required',
            'machine_id' => 'required',
            'user_id' => 'required',
            'image' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            DB::beginTransaction();
            $imagePath = saveResizeImage($request->image, 'work-order-image', 1024, 'jpg');
            $loggedInUserId = Auth::id();
            $workOrder = $this->createWorkOrder($request, $imagePath, $loggedInUserId, $request->schedule_period);
            if ($request->selected_time == 'weekly') {
                for ($i = 1; $i <= $request->no_of_repetitions; $i++) {
                    scheduleWorkOrder($workOrder, 'weekly', $i);
                }
            } elseif ($request->selected_time == 'monthly') {
                for ($i = 1; $i <= $request->no_of_repetitions; $i++) {
                    scheduleWorkOrder($workOrder, 'monthly', $i);
                }
            } elseif ($request->selected_time == 'yearly') {
                for ($i = 1; $i <= $request->no_of_repetitions; $i++) {
                    scheduleWorkOrder($workOrder, 'yearly', $i);
                }
            }
             // Get the assigned user IDs from the request and find their usernames
            $assignedUserIds = $request->input('user_id'); // Assuming 'user_id' is the field with assigned user IDs
            $assignedUsers = User::whereIn('id', $assignedUserIds)->pluck('username')->toArray();

            // Call the function to create notifications
            $this->createWorkOrderNotifications($workOrder->name, $assignedUsers, Auth::user()->username);

            DB::commit();
			return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Arbeitsauftrag erfolgreich erstellt',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $workOrder = WorkOrder::find($id);
       
        if ($workOrder) {
            
            // Fetch the id's of users that have same users
            $userIds = UserWorkOrder::where('work_order_id', $id)
                ->distinct()
                ->pluck('user_id')
                ->toArray();
                // fetch username based on usesIds 
                $userNames = User::whereIn('id', $userIds)
                ->pluck('username')
                ->toArray();    
                
            return view('backend.workorder.detail', ['userNames' => $userNames, 'workOrder' => $workOrder]);
        }

        return response()->json(['error' => 'Work order not found.'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $workOrder = WorkOrder::find($id);
            if ($workOrder) {
                $workOrder->status = $request->status;
                $workOrder->save();

                return response()->json([
                    'status' => JsonResponse::HTTP_OK,
                    'message' => 'Der Arbeitsauftragsstatus wurde erfolgreich aktualisiert',
                ], JsonResponse::HTTP_OK);
            }

            return response()->json([
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'message' => 'Work order not found',
            ], JsonResponse::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workOrders = WorkOrder::findOrFail($id);
        $userWorkOrder = UserWorkOrder::where('work_order_id', $id)->get();
        $loggedInUserId = Auth::id();
        $locations = Location::all();
        $machinesWithoutType = Machine::whereNull('machine_type_id')->get();
        $machineTypes = MachineType::with('machines')->get();
        $users = User::where('id', '!=', $loggedInUserId)->get();
        return view('backend.workorder.edit', compact('users', 'locations', 'machinesWithoutType', 'userWorkOrder', 'machineTypes', 'workOrders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location_id' => 'required',
            'machine_id' => 'required',
            'user_id' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            DB::beginTransaction();
            $workOrder = WorkOrder::findOrFail($id);

            if ($request->has('image')) {
                $imagePath = saveResizeImage($request->image, 'work-order-image', 1024, 'jpg');
                $workOrder->image_url = $imagePath;
            }
            if ($request->has('schedule_period')) {
                $workOrder->schedule_period = $request->schedule_period;
            }
            $loggedInUserId = Auth::id();
            $workOrder->update([
                'name' => $request->name,
                'description' => $request->description,
                'estimate_hour' => $request->estimate_hour,
                'estimate_minute' => $request->estimate_minute,
                'schedule_period_time' => $request->time_field,
                'selected_time' => $request->selected_time ?? 'no',
                'priority' => $request->priority,
                'created_by' => $loggedInUserId,
            ]);
            UserWorkOrder::where('work_order_id', $workOrder->id)->delete();
            if ($request->has('user_id') && is_array($request->user_id)) {
                foreach ($request->user_id as $userId) {
                    UserWorkOrder::updateOrCreate(
                        [
                            'work_order_id' => $workOrder->id,
                            'user_id' => $userId,
                        ],
                        [
                            'location_id' => $request->location_id,
                            'machine_id' => $request->machine_id,
                        ]
                    );
                }
            }

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Arbeitsauftrag erfolgreich erstellt',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    try {
        $workOrder = WorkOrder::findOrFail($id);
        $relatedUserWorkOrders = UserWorkOrder::where('work_order_id', $id)->get();

        foreach ($relatedUserWorkOrders as $userWorkOrder) {
            $userWorkOrder->delete();
        }

        $workOrder->delete();

        // Benachrichtigungen erstellen, nachdem der Eintrag gelöscht wurde
        $assignedUserIds = $relatedUserWorkOrders->pluck('user_id')->toArray();
        $assignedUsers = User::whereIn('id', $assignedUserIds)->pluck('username')->toArray();
        $this->createWorkOrderNotificationsDelete($workOrder->name, $assignedUsers, Auth::user()->username);

        return response()->json([
            'success' => true,
            'message' => 'Arbeitsauftrag und zugehörige Einträge erfolgreich gelöscht',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Arbeitsauftrag und zugehörige Einträge konnten nicht gelöscht werden',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    // public function calendar(Request $request)
    // {
    //     $userWorkOrders = UserWorkOrder::with('workOrder', 'machine')->get();

    //     $events = $userWorkOrders->map(function ($userWorkOrder) {
    //         $workOrder = $userWorkOrder->workOrder;
    //         $machine = $userWorkOrder->machine;
    //         $schedulePeriod = $workOrder->schedule_period;

    //         // Check if the schedule period contains ' to ' indicating a range
    //         if (strpos($schedulePeriod, ' to ') === false) {
    //             $startDate = date('Y-m-d', strtotime($schedulePeriod));
    //             $endDate = $startDate; // For single date, set the end date as the same
    //         } else {
    //             list($startDate, $endDate) = explode(' to ', $schedulePeriod);
    //             $startDate = date('Y-m-d', strtotime($startDate));
    //             $endDate = date('Y-m-d', strtotime($endDate));
    //         }

    //         $locationName = $userWorkOrder->location ? $userWorkOrder->location->name : null;

    //         return [
    //             'id' => $workOrder->id,
    //             'title' => $workOrder->name,
    //             'priority' => $workOrder->status,
    //             'start_date' => $startDate,
    //             'end_date' => $endDate,
    //             'location' => $locationName,
    //             'machine' => $machine->name,
    //             'time' => $workOrder->schedule_period_time,
    //         ];
    //     });

    //     return response()->json($events);
    // }

    public function calendar(Request $request){
        $userWOIds = UserWorkOrder::where('user_id', auth()->id())
        ->distinct()
        ->pluck('work_order_id')
        ->toArray();
    
$workOrders = WorkOrder::whereIn('id', $userWOIds)
        ->orWhere('created_by', auth()->id())->get();

$userWorkOrders = UserWorkOrder::whereIn('work_order_id', $workOrders->pluck('id'))->get();
        // $workOrders = WorkOrder::all();
        // $userWorkOrders = UserWorkOrder::all();
        // $machines = Machine::       
        $machines = Machine::all();
    
        $events = $workOrders->map(function ($workOrder) use ($userWorkOrders, $machines) {
            // Assuming UserWorkOrder and Machine relationships are defined in the WorkOrder model
            $userWorkOrder = $userWorkOrders->where('work_order_id', $workOrder->id)->first();
            $machine = $machines->where('id', $userWorkOrder->machine_id)->first();
            
            $schedulePeriod = $workOrder->schedule_period;
    
            // Check if the schedule period contains ' to ' indicating a range
            if (strpos($schedulePeriod, ' to ') === false) {
                $startDate = date('Y-m-d', strtotime($schedulePeriod));
                $endDate = $startDate; // For single date, set the end date as the same
            } else {
                list($startDate, $endDate) = explode(' to ', $schedulePeriod);
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));
            }
    
            // Adjust the logic based on your relationships and data structure
            $locationName = $userWorkOrder->location ? $userWorkOrder->location->name : null;
    
            return [
                'id' => $workOrder->id,
                'title' => $workOrder->name,
                'priority' => $workOrder->status,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'location' => $locationName,
                'machine' => $machine ? $machine->name : null,
                'time' => $workOrder->schedule_period_time,
            ];
        });
    
        return response()->json($events);
    }
    

    public function getWorkOrderDetails(Request $request)
    {
        $workOrders = WorkOrder::findOrFail($request->id);
        $workOrder = $workOrders;
        $userWorkOrder = UserWorkOrder::where('work_order_id', $request->id)->firstOrFail();
        $loggedInUserId = Auth::id();
        $locations = Location::all();
        $machinesWithoutType = Machine::whereNull('machine_type_id')->get();
        $machineTypes = MachineType::with('machines')->get();
        $users = User::where('id', '!=', $loggedInUserId)->get();
       
        if ($workOrder) {
            // Fetch the id's of users that have same users
            $userIds = UserWorkOrder::where('work_order_id', $request->id)
                ->distinct()
                ->pluck('user_id')
                ->toArray();
                // fetch username based on usesIds 
                $userNames = User::whereIn('id', $userIds)
                ->pluck('username')
                ->toArray();
        }  
        return view('backend.workorder.celender-edit', compact('users', 'locations', 'machinesWithoutType', 'userWorkOrder', 'machineTypes', 'workOrders','workOrder', 'userNames'))->render();
    }

    public function createWorkOrder($request, $imagePath, $loggedInUserId, $schedulePeriod) {
        $workOrder = WorkOrder::create([
            'name' => $request->name,
            'image_url' => $imagePath,
            'description' => $request->description,
            'estimate_hour' => $request->estimate_hour,
            'estimate_minute' => $request->estimate_minute,
            'schedule_period_time' => $request->time_field,
            'selected_time' => 'no',
            'schedule_period' => $schedulePeriod,
            'priority' => $request->priority ?? 'no',
            'created_by' => $loggedInUserId,
        ]);
        foreach ($request->user_id as $userId) {
            UserWorkOrder::create([
                'user_id' => $userId,
                'work_order_id' => $workOrder->id,
                'location_id' => $request->location_id,
                'machine_id' => $request->machine_id,
            ]);
        }
        return $workOrder;
    }
    protected function createWorkOrderNotifications($workOrderName, $assignedUsers, $creatorUsername)
    {
        // Create a notification for the Work Order creator
        Notifications::create([
            'created_for' => $creatorUsername,
            'created_date' => now(),
            'message' => "Arbeitsauftrag " . $workOrderName . " erstellt!",
            'type' => "workordercreated",
            'status' => "not read"
        ]);

        // Create notifications for each assigned user
        foreach ($assignedUsers as $username) {
            Notifications::create([
                'created_for' => $username,
                'created_date' => now(),
                'message' => "Arbeitsauftrag " . $workOrderName . " zugewiesen!",
                'type' => "workordercreated",
                'status' => "not read"
            ]);
        }
    }
    
protected function createWorkOrderNotificationsDelete($workOrderName, $assignedUsers, $creatorUsername)
{
    // Benachrichtigung für den Ersteller des Arbeitsauftrags erstellen
    Notifications::create([
        'created_for' => $creatorUsername,
        'created_date' => now(),
        'message' => "Arbeitsauftrag " . $workOrderName . " gelöscht!",
        'type' => "workorderdeleted",
        'status' => "not read"
    ]);

    // Benachrichtigungen für jeden zugewiesenen Benutzer erstellen
    foreach ($assignedUsers as $username) {
        Notifications::create([
            'created_for' => $username,
            'created_date' => now(),
            'message' => "Arbeitsauftrag " . $workOrderName . " wurde gelöscht!",
            'type' => "workorderdeleted",
            'status' => "not read"
        ]);
    }
}
}
