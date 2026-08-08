@extends('layouts.admin')

@section('title', 'إدارة المستودعات والمتاجر الطبية')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">المستودعات والمتاجر الطبية</h1>
        <button onclick="document.getElementById('newWarehouseModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow">
            + إضافة مستودع جديد
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($warehouses as $wh)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-mono bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $wh->code }}</span>
                        <h3 class="text-lg font-bold text-slate-800 mt-1">{{ $wh->name_ar }}</h3>
                        <p class="text-xs text-slate-500">{{ $wh->city }} - {{ $wh->address }}</p>
                    </div>
                    @if($wh->is_main)
                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full">المستودع الرئيسي</span>
                    @endif
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                    <span>عدد الدفعات المتوفرة:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $wh->batches_count }} دفعات</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-8 rounded-2xl text-center text-slate-400 border border-slate-200">
                لا توجد مستودعات مسجلة بعد.
            </div>
        @endforelse
    </div>
</div>

<!-- Modal -->
<div id="newWarehouseModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">إضافة مستودع جديد</h3>
        <form action="{{ route('admin.inventory.warehouses.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">اسم المستودع (بالعربي)</label>
                <input type="text" name="name_ar" required class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">رمز المستودع (Code)</label>
                <input type="text" name="code" required placeholder="WH-01" class="w-full border-slate-200 rounded-xl p-2.5 text-sm uppercase">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">المدينة</label>
                <input type="text" name="city" required value="الرياض" class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">العنوان التفصيلي</label>
                <input type="text" name="address" class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_main" id="is_main" value="1">
                <label for="is_main" class="text-xs font-bold text-slate-700">تعيين كمستودع رئيسي</label>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('newWarehouseModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-blue-600 text-white font-medium px-4 py-2 rounded-xl text-sm">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
