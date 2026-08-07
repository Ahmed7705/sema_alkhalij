<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceManagerController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::where('type', 'service')->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ]);

        $validated['slug'] = Str::slug($request->title, '-', 'ar');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        DB::transaction(function () use ($request, &$validated) {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/services'), $filename);
                $validated['image'] = 'images/services/' . $filename;
            }

            $service = Service::create($validated);

            AuditLog::log('CREATE_SERVICE', $service, [], $service->toArray());
        });

        return redirect()->route('admin.services.index')->with('success', 'تم إضافة الخدمة الطبية بنجاح.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::where('type', 'service')->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        DB::transaction(function () use ($request, $service, &$validated) {
            $oldData = $service->toArray();

            if ($request->has('remove_image')) {
                if ($service->image && file_exists(public_path($service->image))) {
                    @unlink(public_path($service->image));
                }
                $validated['image'] = null;
            } elseif ($request->hasFile('image')) {
                if ($service->image && file_exists(public_path($service->image))) {
                    @unlink(public_path($service->image));
                }
                $file = $request->file('image');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/services'), $filename);
                $validated['image'] = 'images/services/' . $filename;
            }

            $service->update($validated);

            AuditLog::log('UPDATE_SERVICE', $service, $oldData, $service->toArray());
        });

        return redirect()->route('admin.services.index')->with('success', 'تم تعديل الخدمة الطبية بنجاح.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        DB::transaction(function () use ($service) {
            $oldData = $service->toArray();

            if ($service->image && file_exists(public_path($service->image))) {
                @unlink(public_path($service->image));
            }
            $service->delete();

            AuditLog::log('DELETE_SERVICE', $service, $oldData, []);
        });

        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة الطبية بنجاح.');
    }
}

