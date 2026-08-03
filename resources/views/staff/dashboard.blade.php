<x-app-layout>
    <div class="py-12 bg-surface min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 text-right dir-rtl">
            
            {{-- Header Title --}}
            <div class="bg-gradient-to-r from-[#0F4C3A] to-primary p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-black mb-1">لوحة عمليات منفذي الخدمة الطبية</h2>
                    <p class="text-xs text-medical-200">إدارة الزيارات الطبية المسندة، متابعة الحالات، وتحديث مسار التنفيذ</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 bg-white/10 rounded-2xl text-xs font-bold border border-white/10">الكادر الطبي: {{ Auth::user()->name }}</span>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-gray-500">زيارات اليوم المسندة</span>
                    <div class="text-3xl font-black text-primary dir-ltr text-right">{{ $todaysVisits }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-amber-600">في انتظار القبول</span>
                    <div class="text-3xl font-black text-amber-600 dir-ltr text-right">{{ $pendingAcceptance }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-blue-600">زيارات جاري تنفيذها</span>
                    <div class="text-3xl font-black text-blue-600 dir-ltr text-right">{{ $inProgress }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-emerald-600">زيارات مكتملة التنفيذ</span>
                    <div class="text-3xl font-black text-emerald-600 dir-ltr text-right">{{ $completed }}</div>
                </div>
            </div>

            {{-- Assigned Visits Table --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
                <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-4">جدول الزيارات المسندة للكادر</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-extrabold">
                                <th class="p-4">رقم الحجز</th>
                                <th class="p-4">المريض / العميل</th>
                                <th class="p-4">الخدمة المطلوبة</th>
                                <th class="p-4">التاريخ والوقت</th>
                                <th class="p-4">العنوان والمدينة</th>
                                <th class="p-4">الحالة التشغيلية</th>
                                <th class="p-4 text-center">الإجراءات والتحكم</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($assignedVisits as $visit)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="p-4 font-black text-primary dir-ltr text-right">{{ $visit->booking_number }}</td>
                                    <td class="p-4 font-bold text-gray-800">{{ $visit->patient_name ?? ($visit->user->name ?? 'غير محدد') }}</td>
                                    <td class="p-4 font-bold text-accent">{{ $visit->service->title ?? 'خدمة منزلية' }}</td>
                                    <td class="p-4 text-gray-600 dir-ltr text-right">{{ $visit->booking_date }} | {{ $visit->booking_time }}</td>
                                    <td class="p-4 text-gray-500">{{ $visit->city }} - {{ $visit->address }}</td>
                                    <td class="p-4">
                                        @if($visit->status === 'assigned')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700">بانتظار القبول</span>
                                        @elseif($visit->status === 'accepted')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700">تم القبول</span>
                                        @elseif($visit->status === 'in_progress')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700">جاري التنفيذ</span>
                                        @elseif($visit->status === 'completed')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700">مكتملة</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-700">{{ $visit->status }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('staff.visits.update-status', $visit->id) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf
                                            @if($visit->status === 'assigned')
                                                <button type="submit" name="status" value="accepted" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow">قبول الزيارة</button>
                                            @elseif($visit->status === 'accepted')
                                                <button type="submit" name="status" value="in_progress" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold shadow">بدء الزيارة</button>
                                            @elseif($visit->status === 'in_progress')
                                                <button type="submit" name="status" value="completed" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow">إكمال الخدمة</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 font-bold">لا توجد زيارات طبية مسندة إليك حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $assignedVisits->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
