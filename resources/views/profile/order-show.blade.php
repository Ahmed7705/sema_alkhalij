<x-app-layout>
    <div class="py-10 bg-surface min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-right dir-rtl">
            
            {{-- Header & Breadcrumb --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gray-200 pb-6">
                <div>
                    <a href="{{ route('profile') }}" class="text-xs font-bold text-gray-400 hover:text-primary flex items-center gap-1 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>العودة لبوابة حسابي</span>
                    </a>
                    <h1 class="text-2xl font-black text-primary">تفاصيل طلب الشراء #{{ $order->order_number }}</h1>
                </div>
                <div>
                    <span class="px-4 py-2 rounded-xl text-xs font-bold shadow-sm inline-block
                        @if($order->status === 'completed' || $order->status === 'delivered') bg-emerald-100 text-emerald-800 border border-emerald-200
                        @elseif($order->status === 'processing' || $order->status === 'shipped') bg-blue-100 text-blue-800 border border-blue-200
                        @else bg-amber-100 text-amber-800 border border-amber-200 @endif">
                        حالة الطلب: {{ __($order->status) }}
                    </span>
                </div>
            </div>

            {{-- Order Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-400">تاريخ الطلب</span>
                    <span class="block font-black text-sm text-primary dir-ltr text-right">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-400">طريقة وحالة الدفع</span>
                    <span class="block font-black text-sm text-emerald-600">{{ $order->payment_method ?? 'بطاقة مدى/ائتمان' }} ({{ $order->payment_status === 'paid' ? 'مدفوع' : 'معلق' }})</span>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-400">الإجمالي النهائي للفاتورة</span>
                    <span class="block font-black text-base text-accent dir-ltr text-right">{{ number_format($order->total_amount, 2) }} ر.س</span>
                </div>
            </div>

            {{-- Products Table --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
                <h3 class="font-black text-sm text-primary border-b border-gray-100 pb-3">المنتجات والأجهزة المشتراة</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="bg-surface text-gray-500 font-bold border-b border-gray-100">
                                <th class="p-3">المنتج</th>
                                <th class="p-3 text-center">السعر الفردي</th>
                                <th class="p-3 text-center">الكمية</th>
                                <th class="p-3 text-left">الإجمالي الفرعي</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="p-3 font-bold text-primary">
                                        {{ $item->product ? $item->product->name : ($item->product_name ?? 'منتج طبي') }}
                                    </td>
                                    <td class="p-3 text-center font-bold text-gray-700 dir-ltr">{{ number_format($item->price, 2) }} ر.س</td>
                                    <td class="p-3 text-center font-black text-primary">{{ $item->quantity }}</td>
                                    <td class="p-3 text-left font-black text-accent dir-ltr">{{ number_format($item->price * $item->quantity, 2) }} ر.س</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Invoice Calculation with Dynamic VAT Rate --}}
                <div class="border-t border-gray-100 pt-6 max-w-sm mr-auto space-y-2 text-xs">
                    @php
                        $subtotal = $order->total_amount / (1 + ($vatRate / 100));
                        $vatAmount = $order->total_amount - $subtotal;
                    @endphp
                    <div class="flex justify-between text-gray-500 font-bold">
                        <span>المجموع قبل الضريبة:</span>
                        <span class="dir-ltr">{{ number_format($subtotal, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-gray-500 font-bold">
                        <span>ضريبة القيمة المضافة ZATCA ({{ $vatRate }}%):</span>
                        <span class="dir-ltr">{{ number_format($vatAmount, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between text-primary font-black text-sm pt-2 border-t border-gray-100">
                        <span>الإجمالي الشامل للضريبة:</span>
                        <span class="text-accent dir-ltr">{{ number_format($order->total_amount, 2) }} ر.س</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
