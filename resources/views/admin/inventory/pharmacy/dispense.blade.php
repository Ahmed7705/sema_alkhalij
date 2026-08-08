@extends('layouts.admin')

@section('title', 'صرف الأدوية والوصفات الطبية (FEFO)')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto" dir="rtl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">نموذج صرف علاج / وصفة طبية منزلية</h1>
        <a href="{{ route('admin.inventory.pharmacy.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium">← العودة للسجل</a>
    </div>

    @if(session('error'))
        <div class="bg-rose-50 text-rose-800 p-4 rounded-xl border border-rose-200 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        <form action="{{ route('admin.inventory.pharmacy.dispense.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">المستودع / الصيدلية صرف منها</label>
                    <select name="warehouse_id" required class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">المريض المستلم</label>
                    <select name="patient_id" required class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
                        @foreach($patients as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->name }} ({{ $pt->phone ?? 'مريض' }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">الطبيب الموصي (اختياري)</label>
                    <select name="doctor_id" class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
                        <option value="">-- اختر الطبيب المعالج --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">مرتبط بحجز زيارة منزلية (اختياري)</label>
                    <select name="booking_id" class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
                        <option value="">-- اختر الحجز الطبي --</option>
                        @foreach($bookings as $bk)
                            <option value="{{ $bk->id }}">حجز #{{ $bk->booking_number }} - {{ $bk->patient_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4 space-y-3">
                <h3 class="font-bold text-slate-900 text-sm">الأدوية المطلوبة للصرف (يتم الخصم تلقائياً حسب الأقرب تاريخ انتهاء FEFO)</h3>
                
                <div id="dispenseItems" class="space-y-3">
                    <div class="grid grid-cols-12 gap-2 items-center bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <div class="col-span-6">
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">اختر الدواء / المستلزم</label>
                            <select name="items[0][product_id]" required class="w-full border-slate-200 rounded-lg p-2 text-xs">
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} (السعر: {{ number_format($p->price ?? 0, 2) }} ر.س)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">الكمية المصروفة</label>
                            <input type="number" name="items[0][quantity]" value="1" min="1" required class="w-full border-slate-200 rounded-lg p-2 text-xs">
                        </div>
                        <div class="col-span-3">
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">سعر الوحدة (ر.س)</label>
                            <input type="number" step="0.01" name="items[0][unit_price]" placeholder="تلقائي" class="w-full border-slate-200 rounded-lg p-2 text-xs">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ملاحظات الصرف / الجرعة الموصى بها</label>
                <textarea name="notes" rows="2" class="w-full border-slate-200 rounded-xl p-2.5 text-sm" placeholder="مثال: حبة واحدة كل 8 ساعات بعد الأكل"></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-6 py-3 rounded-xl shadow transition">
                    تأكيد الصرف وخصم المخزون (FEFO)
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
