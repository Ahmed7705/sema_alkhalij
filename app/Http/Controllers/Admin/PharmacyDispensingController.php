<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Booking;
use App\Models\MedicationDispense;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyDispensingController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $query = MedicationDispense::with(['patient', 'doctor', 'dispenser', 'warehouse', 'items.product', 'items.batch']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('dispense_number', 'LIKE', "%{$q}%")
                ->orWhereHas('patient', function ($p) use ($q) {
                    $p->where('name', 'LIKE', "%{$q}%");
                });
        }

        $dispenses = $query->latest()->paginate(20)->withQueryString();

        return view('admin.inventory.pharmacy.index', compact('dispenses'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $patients = User::where('role', 'patient')->orderBy('name')->get();
        $doctors = User::whereIn('role', ['doctor', 'nurse', 'medical_staff'])->orderBy('name')->get();
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])->latest()->take(30)->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('admin.inventory.pharmacy.dispense', compact('warehouses', 'patients', 'doctors', 'bookings', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'nullable|exists:users,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
        $patient = User::findOrFail($validated['patient_id']);
        $doctor = !empty($validated['doctor_id']) ? User::find($validated['doctor_id']) : null;
        $booking = !empty($validated['booking_id']) ? Booking::find($validated['booking_id']) : null;

        try {
            $dispense = $this->inventoryService->dispenseMedication(
                $warehouse,
                $patient,
                $doctor,
                $booking,
                $validated['items'],
                Auth::user(),
                $validated['notes'] ?? null
            );

            return redirect()->route('admin.inventory.pharmacy.index')->with('success', "تم صرف العلاج بنجاح برقم عملية {$dispense->dispense_number}");
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
