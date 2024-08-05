<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\SparePart;
use Dompdf\Dompdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('backend.sparparts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $location = Location::all();
        return view('backend.sparparts.modal', [
            'location' => $location,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'spare_part_number' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'stock_location' => 'required|string|max:255',
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
            $image = $request->image;
            $imagePath = saveResizeImage($image, 'Spareparts', 800);

            $qrCodeContent = $request->spare_part_number;
            $qrCodePath = 'qr_codes/' . uniqid('qr_') . '.svg';
            $svg = QrCode::format('svg')->size(300)->generate($qrCodeContent);
            Storage::disk('public')->put($qrCodePath, $svg);

            $totalPrice = $request->current_stock * $request->price_per_piece;
            $spareparts = SparePart::create([
                'location_number' => $request->location_number,
                'spare_part_number' => $request->spare_part_number,
                'name_of_part' => $request->name_of_part,
                'qr_code' => $qrCodePath,
                'supplier' => $request->supplier,
                'image' => $imagePath,
                'location_id' => $request->stock_location,
                'minimum_stock' => $request->minimum_stock,
                'current_stock' => $request->current_stock,
                'price_per_piece' => $request->price_per_piece,
                'total_price' => $totalPrice,
                'status' => $this->calculateStatus($request->current_stock, $request->minimum_stock),
            ]);

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Ersatzteil erfolgreich hinzugefügt!',
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = Location::all();
        $spareparts = SparePart::findOrFail($id);
        return view('backend.sparparts.modal', compact('spareparts', 'location'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'spare_part_number' => 'required|string|max:255',
            // 'stock_location' => 'required|string|max:255',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $spareparts = SparePart::findOrFail($id);
            if ($request->has('image')) {
                $image = $request->file('image');
                $imagePath = saveResizeImage($image, 'Spareparts', 800);
                $spareparts->image = $imagePath;
            }
            $totalPrice = $request->current_stock * $request->price_per_piece;
            $spareparts->update([
                'location_number' => $request->location_number,
                'spare_part_number' => $request->spare_part_number,
                'name_of_part' => $request->name_of_part,
                'supplier' => $request->supplier,
                'location_id' => $request->stock_location,
                'minimum_stock' => $request->minimum_stock,
                'current_stock' => $request->current_stock,
                'price_per_piece' => $request->price_per_piece,
                'total_price' => $totalPrice,
                'status' => $this->calculateStatus($request->current_stock, $request->minimum_stock),
            ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Ersatzteile erfolgreich aktualisiert.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
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
            $spareparts = SparePart::findOrFail($id);
            $spareparts->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Ersatzteil erfolgreich gelöscht!',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
public function dataTable(Request $request)
{
    $userType = auth()->user()->user_type; // Holt den 'user_type' des eingeloggten Benutzers
    $roleAndAccess = \App\Models\RoleAndAccess::where('role_name', $userType)->first();

    $canEditSparePart = $roleAndAccess && $roleAndAccess->can_edit_sparepart == 'yes';
    $canDeleteSparePart = $roleAndAccess && $roleAndAccess->can_delete_sparepart == 'yes';

    $sparepart = SparePart::with('location')->get();

    return Datatables::of($sparepart)
        ->addColumn('actions', function ($record) use ($canEditSparePart, $canDeleteSparePart) {
            $actions = '<div class="btn-list">';

            if ($canEditSparePart) {
                $actions .= '<a data-act="ajax-modal" data-action-url="' . route('spareparts.edit', $record->id) . '" data-title="Ersatzteil bearbeiten" class="btn btn-sm btn-primary">
                                <span class="fe fe-edit"> </span>
                            </a>';
            }

            if ($canDeleteSparePart) {
                $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('spareparts.destroy', $record->id) . '" data-method="get" data-table="#sparepart_datatable">
                                <span class="fe fe-trash-2"> </span>
                            </button>';
            }

            $actions .= '</div>';
            return $actions;
        })
        ->addColumn('name_of_part', function ($record) {
            return '<div class="d-flex">
                        <span  style="width:2rem;height:2rem;line-height:2rem;"><img src="' . asset('storage/' . $record->image) . '" alt="Part Image" style="height:90%;border-radius: 25%;"></span>
                        <div class="ms-3 mt-0 mt-sm-2 d-block">
                            <h6 class="mb-0 fs-14 fw-semibold">' . $record->name_of_part . '</h6>
                        </div>
                    </div>';
        })
        ->addColumn('location', function ($task) {
            if ($task->location) {
                return $task->location->name . '-' . $task->location_number;
            } else {
                return 'No Available Location';
            }
        })
        ->addColumn('price_per_piece', function ($task) {
            return '€ ' . number_format($task->price_per_piece, 2, ',', '');
        })
        ->addColumn('total_price', function ($task) {
            return '€ ' . number_format($task->total_price, 2, ',', '');
        })
        ->addColumn('status', function ($record) {
            $status = '';
            $badgeClass = '';

            if ($record->status === 'in_stock') {
                $status = 'Auf Lager';
                $badgeClass = 'success';
            } elseif ($record->status === 'out_of_stock') {
                $status = 'Nicht auf Lager!';
                $badgeClass = 'danger';
            } elseif ($record->status === 'minimum_reached') {
                $status = 'Mindestbestand erreicht (' . $record->current_stock . ')';
                $badgeClass = 'warning';
            }

            return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($status) . '</span>';
        })
        ->rawColumns(['actions', 'name_of_part', 'location', 'status'])
        ->addIndexColumn()->make(true);
}
    public function downloadQR($id)
    {
        $spareparts = SparePart::findOrFail($id);
        $content = view('backend.sparparts.qr-view', compact('spareparts'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        $dompdf->setPaper([0, 0, 140, 140], 'landscape');

        $dompdf->render();

        $pdfFileName = 'qr_code_ersazteil.pdf';

        return $dompdf->stream($pdfFileName);
    }
    private function calculateStatus($currentStock, $minimumStock)
    {
        if ($currentStock <= 0) {
            return 'out_of_stock';
        } elseif ($currentStock < $minimumStock) {
            return 'minimum_reached';
        } else {
            return 'in_stock';
        }
    }
    // public function downloadQR($id)
    // {
    //     $spareparts = SparePart::findOrFail($id);
    //     $content = view('backend.sparparts.qr-view', compact('spareparts'))->render();
    //     return Response::make($content)
    //     ->header('Content-Type', 'text/html')
    //     ->header('Content-Disposition', 'attachment; filename="sparepart_details.html"');
    // }

    public function generateQrCodes()
    {
        $spareParts = SparePart::whereNull('qr_code')->orWhere('qr_code', '')->get();

        foreach ($spareParts as $part) {
            $qrCodeContent = $part->spare_part_number;
            $qrCodePath = 'qr_codes/' . uniqid('qr_') . '.svg';
            $svg = QrCode::format('svg')->size(300)->generate($qrCodeContent);
            Storage::disk('public')->put($qrCodePath, $svg);

            $part->qr_code = $qrCodePath;
            $part->save();
        }

        return response()->json(['message' => 'QR-Codes erfolgreich generiert']);
    }
}
