<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Get the authenticated user's wishlist items.
     */
    public function index()
    {
        $userId = Auth::id();
        $items = WishlistItem::where('user_id', $userId)
            ->with(['product', 'service'])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $items,
        ]);
    }

    /**
     * Toggle product/service in user's wishlist (Add if missing, remove if present).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $serviceId = $request->service_id;

        if (!$productId && !$serviceId) {
            return response()->json(['message' => 'يرجى تحديد المنتج أو الخدمة.'], 422);
        }

        $query = WishlistItem::where('user_id', $userId);
        if ($productId) {
            $query->where('product_id', $productId);
        } else {
            $query->where('service_id', $serviceId);
        }

        $existing = $query->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'تمت إزالة العنصر من المفضلة.',
            ]);
        }

        $item = WishlistItem::create([
            'user_id' => $userId,
            'session_id' => session()->getId(),
            'product_id' => $productId,
            'service_id' => $serviceId,
        ]);

        return response()->json([
            'status' => 'added',
            'message' => 'تمت إضافة العنصر إلى المفضلة بنجاح.',
            'data' => $item,
        ]);
    }

    /**
     * Remove a specific item from wishlist with strict IDOR protection.
     */
    public function destroy(WishlistItem $wishlistItem)
    {
        if ((int)$wishlistItem->user_id !== (int)Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل أو حذف مفضلة مستخدم آخر.');
        }

        $wishlistItem->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم حذف العنصر من المفضلة بنجاح.',
            ]);
        }

        return redirect()->back()->with('success', 'تم حذف العنصر من المفضلة.');
    }
}
