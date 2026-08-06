@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Medical Bookings & Visits Management' : 'إدارة الحجوزات والزيارات الطبية' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Home Medical Visits Scheduling & Management' : 'إدارة وجدولة الزيارات الطبية المنزلية' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-2xl flex items-center justify-between">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Top Summary Bar --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $isEn ? 'Complete Medical Bookings Register' : 'سجل الحجوزات والزيارات الطبية' }} ({{ $bookings->total() }})</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $isEn ? 'Filter, assign practitioners, and manage medical visit workflows' : 'تصفية وإسناد الممارسين وإدارة مسار تنفيذ الزيارات الطبية' }}</p>
            </div>
        </div>

        {{-- Filters Bar --}}
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Booking #, Patient, Phone...' : 'رقم الحجز، اسم المريض، الجوال...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Workflow Statuses' : 'جميع الحالات التشغيلية' }}</option>
                        <option value="requested" {{ request('status') == 'requested' ? 'selected' : '' }}>{{ $isEn ? 'Requested' : 'مطلوب جديد' }}</option>
                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>{{ $isEn ? 'Assigned' : 'مسند لممارس' }}</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>{{ $isEn ? 'Accepted' : 'مقبول من الكادر' }}</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ $isEn ? 'In Progress' : 'جاري التنفيذ' }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ $isEn ? 'Completed' : 'مكتمل' }}</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>{{ $isEn ? 'Verified ✓' : 'معتمد وموثق ✓' }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ $isEn ? 'Cancelled' : 'ملغى' }}</option>
                    </select>
                </div>

                <div>
                    <select name="assigned_provider_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Practitioners' : 'جميع الممارسين الطبية' }}</option>
                        @if(isset($staffList))
                            @foreach($staffList as $staff)
                                <option value="{{ $staff->id }}" {{ request('assigned_provider_id') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }} ({{ $staff->role }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl font-black text-xs shadow hover:bg-primary-hover transition-colors">
                        {{ $isEn ? 'Filter' : 'تصفية' }}
                    </button>
                    @if(request()->anyFilled(['q', 'status', 'assigned_provider_id', 'date']))
                        <a href="{{ route('admin.bookings.index') }}" class="px-3 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold text-xs hover:bg-gray-200">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Bookings Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">{{ $isEn ? 'Booking #' : 'رقم الحجز' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Requested Service' : 'الخدمة المطلوبة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Patient Name' : 'اسم المريض' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Assigned Practitioner' : 'الممارس المسند' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Visit Date & Time' : 'تاريخ ووقت الزيارة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'City & Address' : 'المدينة والموقع' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة التشغيلية' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Details' : 'التفاصيل والتحكم' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookings as $b)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                                    <a href="{{ route('admin.bookings.show', $b->id) }}" class="hover:underline">#{{ $b->booking_number }}</a>
                                </td>
                                <td class="p-3.5 font-bold text-gray-800">{{ $b->service->title ?? ($isEn ? 'Home Visit' : 'خدمة منزلية') }}</td>
                                <td class="p-3.5 font-bold text-gray-800">
                                    {{ $b->patient_name ?? ($b->user->name ?? '-') }}
                                    @if($b->company)
                                        <span class="block text-[10px] text-accent font-bold">{{ $b->company->name }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5">
                                    @if($b->assignedProvider)
                                        <strong class="text-primary font-bold block">{{ $b->assignedProvider->name }}</strong>
                                        <span class="text-[10px] text-gray-400 block">{{ $b->assignedProvider->role }}</span>
                                    @else
                                        <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">{{ $isEn ? 'Unassigned' : 'غير مسند' }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $b->booking_date }} | {{ $b->booking_time }}</td>
                                <td class="p-3.5 font-bold text-gray-600">{{ $b->city }} - {{ $b->address }}</td>
                                <td class="p-3.5 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($b->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</td>
                                <td class="p-3.5">
                                    @php
                                        $statusBadges = [
                                            'requested' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $isEn ? 'Requested' : 'مطلوب'],
                                            'assigned' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'label' => $isEn ? 'Assigned' : 'تم الإسناد'],
                                            'accepted' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'label' => $isEn ? 'Accepted' : 'تم القبول'],
                                            'in_progress' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'label' => $isEn ? 'In Progress' : 'جاري التنفيذ'],
                                            'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => $isEn ? 'Completed' : 'مكتملة'],
                                            'verified' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-800', 'label' => $isEn ? 'Verified ✓' : 'معتمدة ✓'],
                                            'cancelled' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'label' => $isEn ? 'Cancelled' : 'ملغاة'],
                                        ];
                                        $badge = $statusBadges[$b->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $b->status];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $badge['bg'] }} {{ $badge['text'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-center">
                                    <a href="{{ route('admin.bookings.show', $b->id) }}" class="px-3 py-1.5 bg-[#006C35] text-white font-bold rounded-xl text-[11px] shadow hover:bg-[#00572B] transition-all inline-block">
                                        {{ $isEn ? 'Manage & Assign' : 'التفاصيل والإسناد' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No bookings found matching filter criteria.' : 'لا توجد حجوزات تطابق خيارات البحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-2">
                {{ $bookings->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
