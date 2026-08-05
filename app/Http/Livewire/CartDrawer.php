<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Service;
use Livewire\Component;

class CartDrawer extends Component
{
    public $isOpen = false;

    protected $listeners = [
        'openCart' => 'openDrawer',
        'closeCart' => 'closeDrawer',
        'addToCart' => 'addToCart',
        'removeFromCart' => 'removeFromCart',
        'updateQuantity' => 'updateQuantity',
        'clearCart' => 'clearCart',
    ];

    public function openDrawer()
    {
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }

    public function getSessionId()
    {
        return session()->getId();
    }

    public function getCartItemsProperty()
    {
        $sessionId = $this->getSessionId();
        $userId = auth()->id();

        if ($userId) {
            // Merge & claim guest items into user cart on login
            CartItem::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->update(['user_id' => $userId]);
        }

        return CartItem::where(function ($q) use ($sessionId, $userId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->with(['product', 'service'])->get();
    }

    public function getCartCountProperty()
    {
        return $this->cartItems->sum('quantity');
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

    public function addToCart($type, $id, $quantity = 1)
    {
        $sessionId = $this->getSessionId();
        $userId = auth()->id();

        if ($type === 'product') {
            $product = Product::findOrFail($id);
            $price = $product->discount_price > 0 ? $product->discount_price : $product->price;

            $item = CartItem::where(function ($q) use ($sessionId, $userId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->where('product_id', $id)
            ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
                if ($userId && !$item->user_id) {
                    $item->update(['user_id' => $userId]);
                }
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'product_id' => $id,
                    'service_id' => null,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }
        } elseif ($type === 'service') {
            $service = Service::findOrFail($id);
            $price = $service->discount_price > 0 ? $service->discount_price : $service->price;

            $item = CartItem::where(function ($q) use ($sessionId, $userId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->where('service_id', $id)
            ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
                if ($userId && !$item->user_id) {
                    $item->update(['user_id' => $userId]);
                }
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'product_id' => null,
                    'service_id' => $id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }
        }

        $this->isOpen = true;
        $this->emit('cartUpdated');
    }

    public function updateQuantity($itemId, $qty)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            if ($qty <= 0) {
                $item->delete();
            } else {
                $item->update(['quantity' => $qty]);
            }
        }
        $this->emit('cartUpdated');
    }

    public function removeFromCart($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->delete();
        }
        $this->emit('cartUpdated');
    }

    public function clearCart()
    {
        $sessionId = $this->getSessionId();
        $userId = auth()->id();

        CartItem::where('session_id', $sessionId)
            ->orWhere(function ($q) use ($userId) {
                if ($userId) $q->where('user_id', $userId);
            })->delete();

        $this->emit('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-drawer', [
            'cartItems' => $this->cartItems,
            'cartCount' => $this->cartCount,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);
    }
}
