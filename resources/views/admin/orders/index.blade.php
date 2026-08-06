@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Orders & Invoicing Management' : 'إدارة الطلبات والفوترة' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Medical Store Orders Register & ZATCA e-Invoicing' : 'سجل طلبات المتجر والفوترة الإلكترونية ZATCA' }}</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-5 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        <div class="flex items-center justify-between">
            <h3 class="font-black text-base text-primary">{{ $isEn ? 'All Store Orders & Products' : 'طلبات الشراء والمنتجات بالكامل' }} ({{ $orders->total() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">{{ $isEn ? 'Order & Invoice #' : 'رقم الفاتورة والطلب' }}</th>
                        <th class="p-3">{{ $isEn ? 'Customer Name' : 'اسم العميل' }}</th>
                        <th class="p-3">{{ $isEn ? 'Phone' : 'الجوال' }}</th>
                        <th class="p-3">{{ $isEn ? 'City & Address' : 'المدينة والعنوان' }}</th>
                        <th class="p-3">{{ $isEn ? 'Total Invoice (VAT 15% incl.)' : 'إجمالي الفاتورة (شامل 15%)' }}</th>
                        <th class="p-3">{{ $isEn ? 'Payment Method' : 'طريقة الدفع' }}</th>
                        <th class="p-3">{{ $isEn ? 'Order & Shipping Status' : 'حالة الطلب والشحن' }}</th>
                        <th class="p-3">{{ $isEn ? 'ZATCA Invoice' : 'الفاتورة ZATCA' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">#{{ $o->order_number }}</td>
                            <td class="p-3 font-bold text-gray-800">{{ $o->customer_name ?? ($isEn ? 'Customer' : 'عميل') }}</td>
                            <td class="p-3 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $o->phone }}</td>
                            <td class="p-3 font-bold text-gray-600">{{ $o->city }} - {{ $o->shipping_address }}</td>
                            <td class="p-3 font-black text-accent dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($o->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</td>
                            <td class="p-3 font-bold text-gray-700 uppercase">{{ $o->payment_method }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.orders.status', $o->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="px-2 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-800">
                                        <option value="pending" {{ $o->status === 'pending' ? 'selected' : '' }}>{{ $isEn ? 'Pending Review' : 'قيد المراجعة' }}</option>
                                        <option value="processing" {{ $o->status === 'processing' ? 'selected' : '' }}>{{ $isEn ? 'Processing' : 'قيد التجهيز' }}</option>
                                        <option value="shipped" {{ $o->status === 'shipped' ? 'selected' : '' }}>{{ $isEn ? 'Shipped' : 'تم الشحن' }}</option>
                                        <option value="delivered" {{ $o->status === 'delivered' ? 'selected' : '' }}>{{ $isEn ? 'Delivered' : 'تم التسليم' }}</option>
                                        <option value="cancelled" {{ $o->status === 'cancelled' ? 'selected' : '' }}>{{ $isEn ? 'Cancelled' : 'ملغى' }}</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3">
                                <a href="{{ route('admin.orders.show', $o->id) }}" class="px-3 py-1 bg-primary text-white font-bold rounded-lg text-[10px] hover:bg-primary-hover">
                                    {{ $isEn ? 'View Invoice' : 'معاينة الفاتورة' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $orders->links() }}
        </div>

    </div>
</x-admin-layout>
