<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use Livewire\Component;

class CartBadge extends Component
{
    protected $listeners = [
        'cartUpdated' => '$refresh',
    ];

    public function getSessionId()
    {
        return session()->getId();
    }

    public function getCartCountProperty()
    {
        $sessionId = $this->getSessionId();
        $userId = auth()->id();

        return CartItem::where(function ($q) use ($sessionId, $userId) {
            $q->where('session_id', $sessionId);
            if ($userId) {
                $q->orWhere('user_id', $userId);
            }
        })->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart-badge', [
            'cartCount' => $this->cartCount,
        ]);
    }
}
