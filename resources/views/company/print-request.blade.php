@php
    $isEn = app()->getLocale() == 'en';
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEn ? 'Print Corporate Service Request' : 'طباعة طلب خدمة تعاقدية' }} — {{ $booking->booking_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Alexandria:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Alexandria', 'Outfit', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-card { border: none !important; shadow: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-6 min-h-screen text-gray-800 {{ $isEn ? 'text-left' : 'text-right' }}">

    <div class="max-w-3xl mx-auto space-y-4">

        {{-- No Print Controls --}}
        <div class="no-print flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
            <a href="{{ route('company.portal') }}" class="text-xs font-bold text-gray-600 hover:text-gray-900 flex items-center gap-1">
                ← {{ $isEn ? 'Back to Corporate Portal' : 'العودة لبوابة الشركات' }}
            </a>
            <button onclick="window.print()" class="bg-[#006C35] hover:bg-[#00572B] text-white font-extrabold text-xs px-6 py-2.5 rounded-xl shadow transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ $isEn ? 'Print Document' : 'طباعة التقرير / PDF' }}</span>
            </button>
        </div>

        {{-- Printable Card --}}
        <div class="print-card bg-white p-8 sm:p-12 rounded-3xl border border-gray-200 shadow-lg space-y-8">
            
            {{-- Header & Branding --}}
            <div class="flex items-center justify-between border-b-2 border-primary/20 pb-6">
                <div class="space-y-1">
                    <h1 class="text-2xl font-black text-primary">{{ $isEn ? 'Sema Al-Khalij Medical Services' : 'سيما الخليج للخدمات الطبية المنزلية' }}</h1>
                    <p class="text-xs text-gray-500 font-bold">{{ $isEn ? 'Corporate Services Voucher & Official Visit Order' : 'نموذج طلب وتعميد خدمة طبية منزلية للجهات المتعاقدة' }}</p>
                </div>
                <div class="text-left dir-ltr">
                    <div class="text-xl font-black text-primary">{{ $booking->booking_number }}</div>
                    <div class="text-[11px] text-gray-400 font-bold">{{ $isEn ? 'Date:' : 'التاريخ:' }} {{ $booking->created_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>

            {{-- Company & Contract Banner --}}
            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 text-xs">
                <div>
                    <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contracted Corporate Entity:' : 'جهة التعاقد / الشركة:' }}</span>
                    <strong class="text-gray-800 font-black text-sm block mt-0.5">{{ $booking->company->name ?? '-' }}</strong>
                    <span class="text-gray-500 text-[11px]">CR: {{ $booking->company->cr_number ?? 'N/A' }} | {{ $booking->company->city }}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contract Reference Number:' : 'رقم العقد المبرم:' }}</span>
                    <strong class="text-primary font-black text-sm block mt-0.5 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->contract->contract_number ?? 'CNT-ACTIVE' }}</strong>
                    <span class="text-gray-500 text-[11px]">{{ $isEn ? 'Payment Terms:' : 'شروط التسوية:' }} {{ $booking->contract->payment_terms ?? 'Net 30' }}</span>
                </div>
            </div>

            {{-- Beneficiary Information --}}
            <div class="space-y-3">
                <h3 class="text-sm font-black text-primary border-b border-gray-100 pb-2">{{ $isEn ? 'Beneficiary & Patient Information' : 'بيانات المريض والمستفيد المعتمد' }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Beneficiary Name:' : 'اسم المستفيد / المريض:' }}</span>
                        <span class="font-black text-gray-900 text-sm block mt-1">{{ $booking->patient_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'ID Type & Number:' : 'نوع ورقم الهوية:' }}</span>
                        <span class="font-bold text-gray-800 block mt-1 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ strtoupper($booking->identification_type ?? 'ID') }}: {{ $booking->identification_number }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contact Phone:' : 'رقم الجوال للتواصل:' }}</span>
                        <span class="font-bold text-gray-800 block mt-1 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->phone }}</span>
                    </div>
                </div>
            </div>

            {{-- Visit & Service Details --}}
            <div class="space-y-3">
                <h3 class="text-sm font-black text-primary border-b border-gray-100 pb-2">{{ $isEn ? 'Medical Service & Visit Specifications' : 'تفاصيل الخدمة الطبية المطلوبة وموقع الزيارة' }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Requested Medical Service:' : 'الخدمة الطبية المعتمدة:' }}</span>
                        <span class="font-black text-primary text-sm block mt-1">{{ $booking->service->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Scheduled Date & Time:' : 'تاريخ وموعد الزيارة:' }}</span>
                        <span class="font-bold text-gray-800 block mt-1 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->booking_date }} • {{ $booking->booking_time }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'City & Location:' : 'المدينة والعنوان:' }}</span>
                        <span class="font-bold text-gray-800 block mt-1">{{ $booking->city }} — {{ $booking->address }}</span>
                    </div>
                </div>
            </div>

            {{-- Financial & Pricing Section --}}
            <div class="p-4 bg-primary/5 rounded-2xl border border-primary/20 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Agreed Contract Service Price:' : 'السعر التعاقدي المخصص للخدمة:' }}</span>
                    <span class="text-xs text-gray-400 font-bold">{{ $isEn ? 'Calculated automatically server-side' : 'تم تسقيفه وحسابه برمجياً من العقد النشط' }}</span>
                </div>
                <div class="text-2xl font-black text-primary dir-ltr">
                    {{ number_format($booking->total_price, 2) }} SAR
                </div>
            </div>

            {{-- Footer Signatures & Stamp --}}
            <div class="pt-12 border-t border-gray-200 grid grid-cols-2 gap-8 text-xs text-center">
                <div class="space-y-8">
                    <span class="font-bold text-gray-500 block">{{ $isEn ? 'Corporate Authorized Signature' : 'توقيع وتعميد مسؤول الشركة' }}</span>
                    <div class="border-b border-dashed border-gray-300 w-3/4 mx-auto pt-8"></div>
                </div>
                <div class="space-y-8">
                    <span class="font-bold text-gray-500 block">{{ $isEn ? 'Sema Al-Khalij Medical Operations Stamp' : 'ختم واعتماد إدارة العمليات الطبية' }}</span>
                    <div class="border-b border-dashed border-gray-300 w-3/4 mx-auto pt-8"></div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
