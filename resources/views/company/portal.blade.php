<x-app-layout>
    <div class="py-12 bg-surface min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 text-right dir-rtl" x-data="{ openRequestModal: false }">
            
            {{-- Company Header Banner --}}
            <div class="bg-gradient-to-r from-primary via-[#0a3428] to-[#071f18] p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-white/10">
                <div class="space-y-1">
                    <span class="text-xs text-accent font-black tracking-wide">بوابة الشركات المتعاقدة — Corporate Portal</span>
                    <h2 class="text-3xl font-black">{{ $company->name }}</h2>
                    <p class="text-xs text-medical-200">رقم السجل التجاري: {{ $company->cr_number ?? 'غير مسجل' }} | المدينة: {{ $company->city }}</p>
                </div>
                <div>
                    <button @click="openRequestModal = true" class="bg-accent hover:bg-accent-hover text-white font-black text-xs px-6 py-3.5 rounded-2xl shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>تقديم طلب خدمة جديد لمستفيد</span>
                    </button>
                </div>
            </div>

            {{-- Contract & Metric Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-500 block">رقم العقد الساري</span>
                    <div class="text-xl font-black text-primary dir-ltr text-right">{{ $activeContract->contract_number ?? 'لا يوجد عقد نشط' }}</div>
                    <span class="text-[11px] text-emerald-600 font-bold block">شروط الدفع: {{ $activeContract->payment_terms ?? 'فوري' }}</span>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-500 block">عدد المستفيدين المعتمدين</span>
                    <div class="text-2xl font-black text-accent dir-ltr text-right">{{ $beneficiariesCount }} <span class="text-xs text-gray-400 font-bold">مستفيد</span></div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-500 block">تاريخ صلاحية العقد</span>
                    <div class="text-sm font-black text-gray-800 dir-ltr text-right">{{ $activeContract->start_date ?? '-' }} إلى {{ $activeContract->end_date ?? '-' }}</div>
                </div>
            </div>

            {{-- Service Requests Table --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
                <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-4">طلبات الخدمات والمتابعة التشغيلية للشركة</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-extrabold">
                                <th class="p-4">رقم الطلب</th>
                                <th class="p-4">اسم المستفيد</th>
                                <th class="p-4">الهوية الوطنية / الإقامة</th>
                                <th class="p-4">الخدمة المطلوبة</th>
                                <th class="p-4">تاريخ الموعد</th>
                                <th class="p-4">التكلفة التعاقدية</th>
                                <th class="p-4">الحالة التشغيلية</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($companyBookings as $booking)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="p-4 font-black text-primary dir-ltr text-right">{{ $booking->booking_number }}</td>
                                    <td class="p-4 font-bold text-gray-800">{{ $booking->patient_name }}</td>
                                    <td class="p-4 font-bold text-gray-600 dir-ltr text-right">{{ $booking->identification_number }} ({{ $booking->identification_type }})</td>
                                    <td class="p-4 font-bold text-accent">{{ $booking->service->title ?? 'خدمة طبية' }}</td>
                                    <td class="p-4 text-gray-600 dir-ltr text-right">{{ $booking->booking_date }} | {{ $booking->booking_time }}</td>
                                    <td class="p-4 font-black text-primary dir-ltr text-right">{{ number_format($booking->total_price, 2) }} ر.س</td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-primary/10 text-primary">{{ $booking->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 font-bold">لا توجد طلبات خدمات مسجلة للشركة حتى الآن.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $companyBookings->links() }}
                </div>
            </div>

            {{-- New Service Request Modal --}}
            <div x-show="openRequestModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl max-w-2xl w-full p-8 space-y-6 shadow-2xl relative border border-gray-100">
                    <button @click="openRequestModal = false" class="absolute top-6 left-6 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <h3 class="font-black text-xl text-primary border-b border-gray-100 pb-3">تقديم طلب خدمة جديدة لمستفيد الشركة</h3>

                    <form action="{{ route('company.requests.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">اسم المستفيد الكامل</label>
                                <input type="text" name="patient_name" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">نوع الهوية</label>
                                <select name="identification_type" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                                    <option value="saudi_id">هوية وطنية سعودية</option>
                                    <option value="iqama">إقامة متقدمة/مقيم</option>
                                    <option value="border_no">رقم حد</option>
                                    <option value="gcc_id">هوية خليجية</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">رقم الهوية / الإقامة</label>
                                <input type="text" name="identification_number" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr text-right">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">رقم جوال التواصل</label>
                                <input type="text" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr text-right">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">الخدمة الطبية المطلوبة</label>
                                <select name="service_id" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                                    @foreach($services as $serv)
                                        <option value="{{ $serv->id }}">{{ $serv->title }} ({{ number_format($serv->price, 0) }} ر.س)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">تاريخ الموعد</label>
                                <input type="date" name="booking_date" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">وقت الموعد</label>
                                <input type="text" name="booking_time" placeholder="مثال: 10:00 صباحاً" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">المدينة</label>
                                <input type="text" name="city" value="{{ $company->city }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1">العنوان التفصيلي للزيارة المنزلية</label>
                            <input type="text" name="address" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1">ملاحظات إضافية للزيارة</label>
                            <textarea name="notes" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 text-xs font-bold focus:outline-none focus:border-primary"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4">
                            <button type="button" @click="openRequestModal = false" class="px-5 py-2.5 rounded-xl font-bold text-xs text-gray-500 hover:bg-gray-100">إلغاء</button>
                            <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary-hover text-white rounded-2xl font-black text-xs shadow-lg">تأكيد وإرسال الطلب</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
