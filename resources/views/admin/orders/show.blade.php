<x-admin-layout title="تفاصيل الفاتورة ZATCA">
    <x-slot name="headerTitle">معاينة الفاتورة الإلكترونية المعتمدة #{{ $order->order_number }}</x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-gray-200 text-right space-y-6">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-black text-primary">فاتورة ضريبية مبسطة (ZATCA)</h2>
                <p class="text-xs text-gray-500">شركة سيما الخليج للخدمات الطبية • الرقم الضريبي: 310000000000003</p>
            </div>

            <div class="text-left dir-ltr">
                <span class="text-xl font-black text-accent block">#{{ $order->order_number }}</span>
                <span class="text-xs text-gray-400 block">{{ $order->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>

        {{-- ZATCA QR Code & Details --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center bg-surface p-6 rounded-2xl border border-gray-200">
            <div class="md:col-span-2 space-y-2 text-xs">
                <div><span class="text-gray-500 font-bold">اسم العميل:</span> <strong>{{ $order->customer_name }}</strong></div>
                <div><span class="text-gray-500 font-bold">الجوال:</span> <strong dir="ltr">{{ $order->phone }}</strong></div>
                <div><span class="text-gray-500 font-bold">عنوان الشحن:</span> <strong>{{ $order->city }} - {{ $order->shipping_address }}</strong></div>
                <div><span class="text-gray-500 font-bold">طريقة الدفع:</span> <strong class="uppercase text-primary font-black">{{ $order->payment_method }}</strong></div>
            </div>

            <div class="text-center">
                <img src="https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl={{ urlencode($order->zatca_qr) }}" alt="ZATCA QR" class="w-32 h-32 mx-auto bg-white p-2 rounded-xl border border-gray-200 shadow-xs">
                <span class="text-[10px] text-gray-400 font-bold block mt-1">مسح الكود للتحقق ZATCA</span>
            </div>
        </div>

        {{-- Items Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-right border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">العنصر</th>
                        <th class="p-3">النوع</th>
                        <th class="p-3">الكمية</th>
                        <th class="p-3">السعر الفردي</th>
                        <th class="p-3">الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        @php
                            $itemTitle = $item->product ? $item->product->title : ($item->service ? $item->service->title : 'عنصر طبي');
                            $itemType = $item->product ? 'منتج طبي' : 'خدمة منزلية';
                        @endphp
                        <tr class="border-b border-gray-100">
                            <td class="p-3 font-bold text-primary">{{ $itemTitle }}</td>
                            <td class="p-3 font-bold text-gray-500">{{ $itemType }}</td>
                            <td class="p-3 font-bold text-gray-800">{{ $item->quantity }}</td>
                            <td class="p-3 font-bold text-gray-800 dir-ltr text-right">{{ number_format($item->price, 2) }} ر.س</td>
                            <td class="p-3 font-black text-accent dir-ltr text-right">{{ number_format($item->total, 2) }} ر.س</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Price Breakdown --}}
        <div class="bg-surface p-4 rounded-2xl space-y-2 text-xs border border-gray-200">
            <div class="flex items-center justify-between text-gray-600">
                <span>المجموع الفرعي (غير شامل الضريبة):</span>
                <span class="font-bold dir-ltr">{{ number_format($order->subtotal, 2) }} ر.س</span>
            </div>
            <div class="flex items-center justify-between text-gray-600">
                <span>ضريبة القيمة المضافة (15% VAT):</span>
                <span class="font-bold dir-ltr">{{ number_format($order->tax, 2) }} ر.س</span>
            </div>
            <div class="flex items-center justify-between pt-2 border-t border-gray-200 text-sm font-black text-primary">
                <span>الإجمالي النهائي المطلوب:</span>
                <span class="text-base font-black text-accent dir-ltr">{{ number_format($order->total_price, 2) }} ر.س</span>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-between">
            <button onclick="window.print()" class="btn-accent px-6 py-2.5 rounded-xl text-xs font-bold shadow-md">
                طباعة الفاتورة PDF
            </button>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-gray-500 hover:text-primary">
                &rarr; العودة لقائمة الطلبات
            </a>
        </div>

    </div>
</x-admin-layout>
