<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Support\Str;
use App\Events\BookingCreated;

class ServiceBookingModal extends Component
{
    public $isOpen = false;
    public $step = 1;

    // Booking Data
    public $service_id = null;
    public $selectedService = null;
    public $booking_date = '';
    public $booking_time = '10:00 صباحاً - 12:00 ظهراً';
    public $city = 'جدة';
    public $address = '';
    public $phone = '';
    public $patient_name = '';
    public $payment_method = 'cash';
    public $notes = '';

    // Success State
    public $isCompleted = false;
    public $completedBookingNumber = '';

    protected $listeners = ['openBookingModal', 'selectService'];

    public function mount($serviceId = null)
    {
        $this->booking_date = date('Y-m-d', strtotime('+1 day'));
        if (auth()->check()) {
            $user = auth()->user();
            $this->patient_name = $user->name ?? '';
            $this->phone = $user->phone ?? '';
            $defaultAddr = $user->addresses()->where('is_default', true)->first();
            if ($defaultAddr) {
                $this->city = $defaultAddr->city ?? 'جدة';
                $this->address = $defaultAddr->street_address ?? '';
            }
        }

        if ($serviceId) {
            $this->selectService($serviceId);
        }
    }

    public function openBookingModal($serviceId = null)
    {
        $this->resetErrorBag();
        $this->isOpen = true;
        $this->isCompleted = false;
        
        if ($serviceId) {
            $this->selectService($serviceId);
            $this->step = 2; // Jump directly to Step 2 (Date & Time Picker)!
        } else {
            $firstService = Service::where('is_active', true)->first();
            if ($firstService) {
                $this->selectService($firstService->id);
            }
            $this->step = 1;
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->step = 1;
        $this->isCompleted = false;
    }

    public function selectService($serviceId)
    {
        $this->service_id = $serviceId;
        $this->selectedService = Service::find($serviceId);
    }

    public function goToStep($targetStep)
    {
        $this->step = $targetStep;
    }

    public function nextStep()
    {
        $this->resetErrorBag();

        if ($this->step === 1) {
            $this->validate([
                'service_id' => 'required|exists:services,id',
            ], [
                'service_id.required' => 'يرجى اختيار الخدمة الطبية المراد حجزها.',
            ]);
            $this->selectedService = Service::find($this->service_id);
            $this->step = 2;
        } elseif ($this->step === 2) {
            $this->validate([
                'booking_date' => 'required|date|after_or_equal:today',
                'booking_time' => 'required|string',
            ], [
                'booking_date.required' => 'يرجى تحديد تاريخ الزيارة الطبية.',
                'booking_date.after_or_equal' => 'يرجى اختيار تاريخ اليوم أو تاريخ قادم.',
                'booking_time.required' => 'يرجى اختيار الفترة الزمنية المناسبة.',
            ]);
            $this->step = 3;
        } elseif ($this->step === 3) {
            $this->validate([
                'patient_name' => 'required|string|min:3|max:100',
                'phone' => 'required|string|min:9|max:15',
                'city' => 'required|string',
                'address' => 'required|string|min:5',
            ], [
                'patient_name.required' => 'اسم المريض مطلوب.',
                'phone.required' => 'رقم الهاتف للتواصل مطلوب.',
                'city.required' => 'يرجى اختيار المدينة.',
                'address.required' => 'تفاصيل العنوان واسم الحي والشارع مطـلوبة.',
            ]);
            $this->step = 4;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submitBooking()
    {
        $this->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'patient_name' => 'required|string',
            'phone' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $service = Service::findOrFail($this->service_id);
        $totalPrice = $service->discount_price ?? $service->price;
        $bookingNumber = 'BK-' . strtoupper(Str::random(6));

        $booking = Booking::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'booking_number' => $bookingNumber,
            'service_id' => $service->id,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
            'city' => $this->city,
            'address' => $this->address . ' (اسم المريض: ' . $this->patient_name . ')',
            'phone' => $this->phone,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
        ]);

        try {
            event(new BookingCreated($booking));
        } catch (\Throwable $e) {
            // Ignore if email listener fails
        }

        $this->completedBookingNumber = $bookingNumber;
        $this->isCompleted = true;
    }

    public function render()
    {
        $services = Service::where('is_active', true)->with('category')->get();
        return view('livewire.service-booking-modal', [
            'services' => $services,
        ]);
    }
}
