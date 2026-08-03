<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ZatcaInvoiceService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public $name = '';
    public $phone = '';
    public $city = 'جدة';
    public $address = '';
    public $notes = '';
    public $payment_method = 'cash';

    public $isCompleted = false;
    public $completedOrder = null;

    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->name = $user->name ?? '';
            $this->phone = $user->phone ?? '';
        }
    }

    public function getSessionId()
    {
        return session()->getId();
    }

    public function getCartItemsProperty()
    {
        $sessionId = $this->getSessionId();
        $userId = auth()->id();

        return CartItem::where(function ($q) use ($sessionId, $userId) {
            $q->where('session_id', $sessionId);
            if ($userId) {
                $q->orWhere('user_id', $userId);
            }
        })->with(['product', 'service'])->get();
    }

    public function getSubtotalProperty()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getTaxProperty()
    {
        return round($this->subtotal * 0.15, 2);
    }

    public function getTotalProperty()
    {
        return $this->subtotal;
    }

    public function submitOrder()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|string|min:9',
            'city' => 'required|string',
            'address' => 'required|string|min:5',
            'payment_method' => 'required|string',
        ], [
            'name.required' => 'يرجى كتابة الاسم الكامل.',
            'phone.required' => 'رقم الجوال مطلوب لتأكيد التوصيل.',
            'city.required' => 'يرجى اختيار المدينة.',
            'address.required' => 'تفاصيل العنوان والعمارة أو الشارع مطلوبة.',
            'payment_method.required' => 'يرجى اختيار طريقة الدفع المفضلة.',
        ]);

        if ($this->cartItems->count() === 0) {
            session()->flash('error', 'سلة التسوق فارغة، يرجى إضافة عناصر أولاً.');
            return;
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $this->name,
                'phone' => $this->phone,
                'city' => $this->city,
                'shipping_address' => $this->address,
                'notes' => $this->notes,
                'subtotal' => $this->subtotal,
                'tax' => $this->tax,
                'total_price' => $this->total,
                'status' => 'pending',
                'payment_status' => $this->payment_method === 'cash' ? 'unpaid' : 'paid',
                'payment_method' => $this->payment_method,
            ]);

            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'service_id' => $item->service_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);

                if ($item->product_id && $item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Generate ZATCA Compliant QR Code Payload
            $zatcaQr = ZatcaInvoiceService::generateTlvQrCode(
                'شركة سيما الخليج للخدمات الطبية',
                '310000000000003',
                $order->created_at->format('Y-m-d\TH:i:s\Z'),
                (float) $order->total_price,
                (float) $order->tax
            );

            $order->update([
                'zatca_qr' => $zatcaQr,
                'zatca_hash' => md5($order->order_number . $order->total_price),
            ]);

            // Clear Cart
            $sessionId = $this->getSessionId();
            $userId = auth()->id();

            CartItem::where('session_id', $sessionId)
                ->orWhere(function ($q) use ($userId) {
                    if ($userId) $q->where('user_id', $userId);
                })->delete();

            DB::commit();

            $this->completedOrder = $order;
            $this->isCompleted = true;
            $this->emit('cartUpdated');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'حدث خطأ أثناء حفظ الطلب: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout', [
            'cartItems' => $this->cartItems,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);
    }
}
