<?php

namespace App\Http\Livewire\Admin;

use App\Models\Booking;
use App\Models\Company;
use App\Models\LabSample;
use App\Models\Service;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdvancedOperationsSearch extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $visitCode = '';
    public $identificationNumber = '';
    public $companyId = '';
    public $serviceId = '';
    public $staffId = '';
    public $status = '';
    public $dateFrom = '';
    public $dateTo = '';

    protected $queryString = [
        'searchQuery' => ['except' => ''],
        'visitCode' => ['except' => ''],
        'identificationNumber' => ['except' => ''],
        'companyId' => ['except' => ''],
        'serviceId' => ['except' => ''],
        'staffId' => ['except' => ''],
        'status' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function updatingSearchQuery() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset([
            'searchQuery',
            'visitCode',
            'identificationNumber',
            'companyId',
            'serviceId',
            'staffId',
            'status',
            'dateFrom',
            'dateTo',
        ]);
        $this->resetPage();
    }

    public function render()
    {
        $query = Booking::with(['service', 'user', 'assignedProvider', 'company']);

        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('booking_number', 'LIKE', "%{$this->searchQuery}%")
                  ->orWhere('patient_name', 'LIKE', "%{$this->searchQuery}%")
                  ->orWhere('phone', 'LIKE', "%{$this->searchQuery}%");
            });
        }

        if ($this->identificationNumber) {
            $query->where('identification_number', 'LIKE', "%{$this->identificationNumber}%");
        }

        if ($this->companyId) {
            $query->where('company_id', $this->companyId);
        }

        if ($this->serviceId) {
            $query->where('service_id', $this->serviceId);
        }

        if ($this->staffId) {
            $query->where('assigned_provider_id', $this->staffId);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->dateFrom) {
            $query->whereDate('booking_date', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('booking_date', '<=', $this->dateTo);
        }

        $results = $query->latest()->paginate(15);

        $companies = Company::where('status', 'active')->get();
        $services = Service::where('is_active', true)->get();
        $staffMembers = User::whereIn('role', ['doctor', 'nurse', 'physio', 'lab_tech'])->get();

        return view('livewire.admin.advanced-operations-search', [
            'results' => $results,
            'companies' => $companies,
            'services' => $services,
            'staffMembers' => $staffMembers,
        ]);
    }
}
