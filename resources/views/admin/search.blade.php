<x-admin-layout title="البحث الشامل بالكامل">
    <x-slot name="headerTitle">نتائج البحث الشامل في نظام الإدارة عن: "{{ $q ?? '' }}"</x-slot>

    <div class="space-y-6 text-right">
        
        {{-- Search Input Form --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.search') }}" method="GET" class="flex gap-3">
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="ابحث باسم عميل، رقم حجز، رقم فاتورة، اسم منتج أو خدمة..." 
                       class="flex-1 h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                <button type="submit" class="btn-accent px-8 rounded-xl font-bold text-xs shadow-md">
                    بحث الآن
                </button>
            </form>
        </div>

        @if(!empty($q))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Bookings Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>الحجوزات الطبية ({{ $bookings->count() }})</span>
                        <span>📋</span>
                    </h3>
                    <div class="space-y-2">
                        @forelse($bookings as $b)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">#{{ $b->booking_number }} - {{ $b->patient_name }}</strong>
                                    <span class="text-gray-500 block">{{ $b->phone }} • {{ $b->city }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-700 font-bold text-[10px]">{{ $b->status }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">لا توجد نتائج في الحجوزات</p>
                        @endforelse
                    </div>
                </div>

                {{-- Orders Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>طلبات الفوترة والمتجر ({{ $orders->count() }})</span>
                        <span>🛒</span>
                    </h3>
                    <div class="space-y-2">
                        @forelse($orders as $o)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">#{{ $o->order_number }} - {{ $o->customer_name }}</strong>
                                    <span class="text-gray-500 block">{{ $o->phone }} • {{ number_format($o->total_price, 2) }} ر.س</span>
                                </div>
                                <a href="{{ route('admin.orders.show', $o->id) }}" class="text-accent font-bold hover:underline text-[11px]">معاينة الفاتورة ←</a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">لا توجد نتائج في طلبات المتجر</p>
                        @endforelse
                    </div>
                </div>

                {{-- Products Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>المنتجات والمستلزمات ({{ $products->count() }})</span>
                        <span>📦</span>
                    </h3>
                    <div class="space-y-2">
                        @forelse($products as $p)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">{{ $p->title }}</strong>
                                    <span class="text-gray-500 block">SKU: {{ $p->sku }} • المخزون: {{ $p->stock }}</span>
                                </div>
                                <span class="font-black text-accent dir-ltr">{{ number_format($p->price, 0) }} ر.س</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">لا توجد نتائج في المنتجات</p>
                        @endforelse
                    </div>
                </div>

                {{-- Users Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>المستخدمين المسجلين ({{ $users->count() }})</span>
                        <span>👥</span>
                    </h3>
                    <div class="space-y-2">
                        @forelse($users as $u)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">{{ $u->name }}</strong>
                                    <span class="text-gray-500 block" dir="ltr">{{ $u->email }} • {{ $u->phone }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-primary/10 text-primary font-bold text-[10px]">{{ $u->role }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">لا توجد نتائج في المستخدمين</p>
                        @endforelse
                    </div>
                </div>

            </div>
        @endif

    </div>
</x-admin-layout>
