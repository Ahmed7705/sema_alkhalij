<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'street' => 'nullable|string|max:255',
            'building_no' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        $isDefault = $request->has('is_default') && $request->is_default;

        if ($isDefault || Address::where('user_id', $userId)->count() === 0) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $validated['user_id'] = $userId;
        Address::create($validated);

        return back()->with('success', 'تم إضافة العنوان بنجاح.');
    }

    public function update(Request $request, Address $address)
    {
        $userId = Auth::id();
        if ((int)$address->user_id !== (int)$userId) {
            abort(403, 'غير مصرح لك بتعديل هذا العنوان.');
        }

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'street' => 'nullable|string|max:255',
            'building_no' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $address->update($validated);

        return back()->with('success', 'تم تحديث العنوان بنجاح.');
    }

    public function destroy(Address $address)
    {
        $userId = Auth::id();
        if ((int)$address->user_id !== (int)$userId) {
            abort(403, 'غير مصرح لك بحذف هذا العنوان.');
        }

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $nextAddress = Address::where('user_id', $userId)->first();
            if ($nextAddress) {
                $nextAddress->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'تم حذف العنوان بنجاح.');
    }

    public function setDefault(Address $address)
    {
        $userId = Auth::id();
        if ((int)$address->user_id !== (int)$userId) {
            abort(403, 'غير مصرح لك بفرز هذا العنوان.');
        }

        Address::where('user_id', $userId)->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'تم تعيين العنوان الافتراضي بنجاح.');
    }
}
