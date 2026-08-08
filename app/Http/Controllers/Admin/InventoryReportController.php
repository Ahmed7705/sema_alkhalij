<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Batch;
use App\Models\MedicationDispense;
use App\Models\PurchaseOrder;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->input('type', 'valuation');

        $valuationReport = [];
        $movementReport = [];
        $expiryReport = [];
        $dispensingReport = [];
        $purchasingReport = [];

        if ($reportType === 'valuation') {
            $valuationReport = Batch::with(['product.category', 'warehouse'])
                ->selectRaw('*, (quantity * buy_price) as total_buy_valuation, (quantity * sell_price) as total_sell_valuation')
                ->latest()
                ->paginate(30);
        } elseif ($reportType === 'movement') {
            $movementReport = StockMovement::with(['product', 'batch', 'fromWarehouse', 'toWarehouse', 'user'])
                ->latest()
                ->paginate(30);
        } elseif ($reportType === 'expiry') {
            $expiryReport = Batch::with(['product', 'warehouse'])
                ->where('expiry_date', '<=', now()->addDays(90))
                ->orderBy('expiry_date', 'asc')
                ->paginate(30);
        } elseif ($reportType === 'dispensing') {
            $dispensingReport = MedicationDispense::with(['patient', 'doctor', 'dispenser', 'warehouse', 'items.product'])
                ->latest()
                ->paginate(30);
        } elseif ($reportType === 'purchasing') {
            $purchasingReport = PurchaseOrder::with(['supplier', 'warehouse', 'items.product'])
                ->latest()
                ->paginate(30);
        }

        return view('admin.inventory.reports.index', compact(
            'reportType',
            'valuationReport',
            'movementReport',
            'expiryReport',
            'dispensingReport',
            'purchasingReport'
        ));
    }
}
