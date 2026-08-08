@extends('layouts.admin')

@section('title', 'إدارة الموردين والشركات الموردة')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">إدارة الموردين وشركات الأدوية</h1>
        <button onclick="document.getElementById('newSupplierModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow">
            + إضافة مورد جديد
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="p-4">الرمز</th>
                        <th class="p-4">اسم المورد</th>
                        <th class="p-4">مسؤول التواصل</th>
                        <th class="p-4">الهاتف / البريد</th>
                        <th class="p-4">السجل التجاري</th>
                        <th class="p-4">الرقم الضريبي</th>
                        <th class="p-4">أوامر الشراء</th>
                        <th class="p-4">الحالة</th>
                        <th class="p-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $sup)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-mono font-bold text-slate-700">{{ $sup->code }}</td>
                            <td class="p-4 font-bold text-slate-900">{{ $sup->name }}</td>
                            <td class="p-4 text-slate-600">{{ $sup->contact_name ?? '-' }}</td>
                            <td class="p-4 text-xs text-slate-500">{{ $sup->phone }} <br> {{ $sup->email }}</td>
                            <td class="p-4 font-mono text-xs">{{ $sup->cr_number ?? '-' }}</td>
                            <td class="p-4 font-mono text-xs">{{ $sup->vat_number ?? '-' }}</td>
                            <td class="p-4 font-bold text-slate-800">{{ $sup->purchase_orders_count }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $sup->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $sup->status === 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('admin.inventory.suppliers.show', $sup->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs">التفاصيل والتاريخ ←</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-400">لا يوجد موردون مسجلون.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="newSupplierModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">إضافة مورد جديد</h3>
        <form action="{{ route('admin.inventory.suppliers.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">اسم المورد / الشركة</label>
                <input type="text" name="name" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">رمز المورد (Code)</label>
                    <input type="text" name="code" required placeholder="SUP-01" class="w-full border-slate-200 rounded-xl p-2 text-sm uppercase">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">اسم مسؤول التواصل</label>
                    <input type="text" name="contact_name" class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">رقم الهاتف</label>
                    <input type="text" name="phone" class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">السجل التجاري (CR)</label>
                    <input type="text" name="cr_number" class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">الرقم الضريبي (VAT)</label>
                    <input type="text" name="vat_number" class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">العنوان</label>
                <input type="text" name="address" class="w-full border-slate-200 rounded-xl p-2 text-sm">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('newSupplierModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-blue-600 text-white font-medium px-4 py-2 rounded-xl text-sm">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
