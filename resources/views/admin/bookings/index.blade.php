@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Medical Bookings & Visits Management' : 'إدارة الحجوزات والزيارات الطبية' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Home Medical Visits Scheduling & Management' : 'إدارة وجدولة الزيارات الطبية المنزلية' }}</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-5 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        <div class="flex items-center justify-between">
            <h3 class="font-black text-base text-primary">{{ $isEn ? 'Complete Medical Bookings Register' : 'سجل الحجوزات الطبية بالكامل' }} ({{ $bookings->total() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">{{ $isEn ? 'Booking #' : 'رقم الحجز' }}</th>
                        <th class="p-3">{{ $isEn ? 'Requested Service' : 'الخدمة المطلوبة' }}</th>
                        <th class="p-3">{{ $isEn ? 'Patient Name' : 'اسم المريض' }}</th>
                        <th class="p-3">{{ $isEn ? 'Phone' : 'الجوال' }}</th>
                        <th class="p-3">{{ $isEn ? 'Visit Date & Time' : 'تاريخ ووقت الزيارة' }}</th>
                        <th class="p-3">{{ $isEn ? 'City & Address' : 'المدينة والموقع' }}</th>
                        <th class="p-3">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                        <th class="p-3">{{ $isEn ? 'Payment Method' : 'طريقة الدفع' }}</th>
                        <th class="p-3">{{ $isEn ? 'Booking Status' : 'حالة الحجز' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">#{{ $b->booking_number }}</td>
                            <td class="p-3 font-bold text-gray-800">{{ $b->service->title ?? ($isEn ? 'Home Visit' : 'خدمة منزلية') }}</td>
                            <td class="p-3 font-bold text-gray-800">{{ $b->patient_name ?? ($isEn ? 'Patient' : 'مريض') }}</td>
                            <td class="p-3 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $b->phone }}</td>
                            <td class="p-3 font-bold text-gray-600">{{ $b->booking_date }} ({{ $b->booking_time }})</td>
                            <td class="p-3 font-bold text-gray-600">{{ $b->city }} - {{ $b->address }}</td>
                            <td class="p-3 font-black text-accent dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($b->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</td>
                            <td class="p-3 font-bold text-gray-700 uppercase">{{ $b->payment_method }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.bookings.status', $b->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="px-2 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-800">
                                        <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>{{ $isEn ? 'Pending Review' : 'قيد المراجعة' }}</option>
                                        <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>{{ $isEn ? 'Confirmed & Processing' : 'مؤكد وجارٍ التنفيذ' }}</option>
                                        <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>{{ $isEn ? 'Completed' : 'مكتمل بنجاح' }}</option>
                                        <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>{{ $isEn ? 'Cancelled' : 'ملغى' }}</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $bookings->links() }}
        </div>

    </div>
</x-admin-layout>
