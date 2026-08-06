@php
    $isEn = app()->getLocale() == 'en';
@endphp
<div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
    
    {{-- Composite Filter Header & Controls --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>{{ $isEn ? 'Advanced Operational Search for Visits & Samples' : 'البحث التشغيلي المتقدم للزيارات والعينات' }}</span>
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $isEn ? 'Composite search by order number, visit code, National ID, assigned staff, and company' : 'البحث المركب برقم الطلب، كود الزيارة، الهوية الوطنية، الموظف المسند، والشركة' }}</p>
            </div>
            <button wire:click="resetFilters" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-2xl transition-all">
                {{ $isEn ? 'Reset Filters' : 'إعادة ضبط الفلاتر' }}
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Patient Name / Order No. / Phone' : 'اسم المريض / رقم الطلب / الجوال' }}</label>
                <input type="text" wire:model.debounce.300ms="searchQuery" placeholder="{{ $isEn ? 'Search by name, order #, or phone...' : 'ابحث بالاسم، الرقم، أو الجوال...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'National ID / Iqama Number' : 'رقم الهوية الوطنية / الإقامة' }}</label>
                <input type="text" wire:model.debounce.300ms="identificationNumber" placeholder="{{ $isEn ? 'Enter ID number...' : 'أدخل رقم الهوية...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Contracted Company' : 'الشركة المتعاقدة' }}</label>
                <select wire:model="companyId" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Companies & Entities' : 'جميع الشركات والجهات' }}</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Medical Service' : 'الخدمة الطبية' }}</label>
                <select wire:model="serviceId" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Services' : 'جميع الخدمات' }}</option>
                    @foreach($services as $serv)
                        <option value="{{ $serv->id }}">{{ $serv->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Assigned Staff / Practitioner' : 'الكادر / الموظف المسند له' }}</label>
                <select wire:model="staffId" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Medical Staff' : 'جميع الكوادر الطبية' }}</option>
                    @foreach($staffMembers as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->role }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Operational Status' : 'الحالة التشغيلية' }}</label>
                <select wire:model="status" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Statuses' : 'جميع الحالات' }}</option>
                    <option value="pending">{{ $isEn ? 'Pending Assignment' : 'بانتظار الإسناد (Pending)' }}</option>
                    <option value="assigned">{{ $isEn ? 'Assigned' : 'مسندة (Assigned)' }}</option>
                    <option value="accepted">{{ $isEn ? 'Accepted' : 'مقبولة (Accepted)' }}</option>
                    <option value="in_progress">{{ $isEn ? 'In Progress' : 'جاري التنفيذ (In Progress)' }}</option>
                    <option value="completed">{{ $isEn ? 'Completed' : 'مكتملة (Completed)' }}</option>
                    <option value="verified">{{ $isEn ? 'Verified' : 'معتمدة نهاییاً (Verified)' }}</option>
                    <option value="cancelled">{{ $isEn ? 'Cancelled' : 'ملغاة (Cancelled)' }}</option>
                </select>
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Date From' : 'تاريخ من' }}</label>
                <input type="date" wire:model="dateFrom" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="font-bold text-gray-700 block mb-1">{{ $isEn ? 'Date To' : 'تاريخ إلى' }}</label>
                <input type="date" wire:model="dateTo" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-bold focus:outline-none focus:border-primary">
            </div>
        </div>
    </div>

    {{-- Operations Results Table --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <h4 class="font-black text-base text-primary">{{ $isEn ? 'Operational & Visit Results' : 'نتائج العمليات والزيارات التشغيلية' }} ({{ $results->total() }})</h4>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition-all">{{ $isEn ? 'Print Report' : 'طباعة التقرير' }}</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full {{ $isEn ? 'text-left' : 'text-right' }} text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-extrabold">
                        <th class="p-4">{{ $isEn ? 'Order No.' : 'رقم الطلب' }}</th>
                        <th class="p-4">{{ $isEn ? 'Patient / Beneficiary' : 'المريض / المستفيد' }}</th>
                        <th class="p-4">{{ $isEn ? 'National ID' : 'الهوية الوطنية' }}</th>
                        <th class="p-4">{{ $isEn ? 'Company' : 'الشركة' }}</th>
                        <th class="p-4">{{ $isEn ? 'Requested Service' : 'الخدمة المطلوبة' }}</th>
                        <th class="p-4">{{ $isEn ? 'Assigned Staff' : 'الكادر المسند' }}</th>
                        <th class="p-4">{{ $isEn ? 'Appointment Date' : 'تاريخ الموعد' }}</th>
                        <th class="p-4">{{ $isEn ? 'Status' : 'الحالة التشغيلية' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($results as $item)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $item->booking_number }}</td>
                            <td class="p-4 font-bold text-gray-800">{{ $item->patient_name ?? ($item->user->name ?? ($isEn ? 'Unassigned' : 'غير محدد')) }}</td>
                            <td class="p-4 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $item->identification_number ?? '-' }}</td>
                            <td class="p-4 text-gray-500 font-bold">{{ $item->company->name ?? ($isEn ? 'Individual' : 'فردي') }}</td>
                            <td class="p-4 font-bold text-accent">{{ $item->service->title ?? ($isEn ? 'Home Visit' : 'خدمة منزلية') }}</td>
                            <td class="p-4 text-gray-700 font-bold">{{ $item->assignedProvider->name ?? ($isEn ? 'Unassigned' : 'غير مسند') }}</td>
                            <td class="p-4 text-gray-500 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $item->booking_date }} | {{ $item->booking_time }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-primary/10 text-primary">{{ $item->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No operational results match the current search filters.' : 'لا توجد نتائج تطابق فلاتر البحث التشغيلي الحالية.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $results->links() }}
        </div>
    </div>

</div>
