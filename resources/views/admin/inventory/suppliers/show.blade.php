@extends('layouts.admin')

@section('title', 'تفاصيل المورد ' . $supplier->name)

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <div>
            <span class="text-xs font-mono bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $supplier->code }}</span>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900 mt-1">{{ $supplier->name }}</h1>
        </div>
        <a href="{{ route('admin.inventory.suppliers.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium">← العودة لقائمة الموردين</a>
    </div>

    <!-- Info Cards -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
        <div>
            <p class="text-xs text-slate-500">مسؤول التواصل</p>
            <p class="font-bold text-slate-800">{{ $supplier->contact_name ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-500">الهاتف / الجوال</p>
            <p class="font-bold text-slate-800">{{ $supplier->phone ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-500">السجل التجاري (CR)</p>
            <p class="font-mono text-slate-800">{{ $supplier->cr_number ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-500">الرقم الضريبي (VAT)</p>
            <p class="font-mono text-slate-800">{{ $supplier->vat_number ?? '-' }}</p>
        </div>
    </div>

    <!-- Purchase Orders History -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 font-bold text-slate-800">سجل أمر الشراء والتوريد لهذه الشركة</div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="p-4">رقم الأمر</th>
                        <th class="p-4">المستودع</th>
                        <th class="p-4">الإجمالي</th>
                        <th class="p-4">الحالة</th>
                        <th class="p-4">تاريخ التوريد</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($supplier->purchaseOrders as $po)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-mono font-bold text-slate-800">{{ $po->po_number }}</td>
                            <td class="p-4">{{ $po->warehouse->name_ar ?? '-' }}</td>
                            <td class="p-4 font-bold text-emerald-600">{{ number_format($po->total_amount, 2) }} ر.س</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold bg-blue-100 text-blue-800">{{ $po->status }}</span>
                            </td>
                            <td class="p-4 text-xs text-slate-400">{{ $po->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">لا توجد أوامر شراء سابقة لهذا المورد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
