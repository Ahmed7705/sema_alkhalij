@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Global Search Results' : 'البحث الشامل بالكامل' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Global Admin Search Results for: "' . ($q ?? '') . '"' : 'نتائج البحث الشامل في نظام الإدارة عن: "' . ($q ?? '') . '"' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Search Input Form --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.search') }}" method="GET" class="flex gap-3">
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="{{ $isEn ? 'Search by customer name, booking #, order #, service/product name, or article...' : 'ابحث باسم عميل، رقم حجز، رقم فاتورة، اسم منتج أو خدمة، مقالة...' }}" 
                       class="flex-1 h-12 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 rounded-xl font-bold text-xs shadow-md">
                    {{ $isEn ? 'Search Now' : 'بحث الآن' }}
                </button>
            </form>
        </div>

        @if(!empty($q))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Bookings Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>{{ $isEn ? 'Medical Bookings' : 'الحجوزات الطبية' }} ({{ $bookings->count() }})</span>
                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
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
                            <p class="text-xs text-gray-400 font-bold py-2">{{ $isEn ? 'No booking results found' : 'لا توجد نتائج في الحجوزات' }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Orders Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>{{ $isEn ? 'Store Orders & Invoices' : 'طلبات الفوترة والمتجر' }} ({{ $orders->count() }})</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                    </h3>
                    <div class="space-y-2">
                        @forelse($orders as $o)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">#{{ $o->order_number }} - {{ $o->customer_name }}</strong>
                                    <span class="text-gray-500 block">{{ $o->phone }} • {{ number_format($o->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</span>
                                </div>
                                <a href="{{ route('admin.orders.show', $o->id) }}" class="text-accent font-bold hover:underline text-[11px] flex items-center gap-1">
                                    <span>{{ $isEn ? 'View Invoice' : 'معاينة الفاتورة' }}</span>
                                    <svg class="w-3.5 h-3.5 {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">{{ $isEn ? 'No order results found' : 'لا توجد نتائج في طلبات المتجر' }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Services Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>{{ $isEn ? 'Medical Services' : 'الخدمات الطبية' }} ({{ $services->count() }})</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                    </h3>
                    <div class="space-y-2">
                        @forelse($services as $s)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">{{ $s->title }}</strong>
                                    <span class="text-gray-500 block">{{ number_format($s->price, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }} • {{ $s->duration_minutes }} {{ $isEn ? 'mins' : 'دقيقة' }}</span>
                                </div>
                                <a href="{{ route('admin.services.edit', $s->id) }}" class="text-accent font-bold hover:underline text-[11px]">{{ $isEn ? 'Edit' : 'تعديل' }}</a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">{{ $isEn ? 'No service results found' : 'لا توجد نتائج في الخدمات الطبية' }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Products Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>{{ $isEn ? 'Products & Devices' : 'المنتجات والمستلزمات' }} ({{ $products->count() }})</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </h3>
                    <div class="space-y-2">
                        @forelse($products as $p)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">{{ $p->title }}</strong>
                                    <span class="text-gray-500 block">SKU: {{ $p->sku }} • {{ $isEn ? 'Stock:' : 'المخزون:' }} {{ $p->stock }}</span>
                                </div>
                                <a href="{{ route('admin.products.edit', $p->id) }}" class="text-accent font-bold hover:underline text-[11px]">{{ $isEn ? 'Edit' : 'تعديل' }}</a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">{{ $isEn ? 'No product results found' : 'لا توجد نتائج في المنتجات' }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Articles Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>{{ $isEn ? 'Blog & Articles' : 'المقالات والمدونة' }} ({{ $articles->count() }})</span>
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    </h3>
                    <div class="space-y-2">
                        @forelse($articles as $a)
                            <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                                <div>
                                    <strong class="text-primary font-black block">{{ $a->title }}</strong>
                                    <span class="text-gray-500 block line-clamp-1">{{ $a->excerpt }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 font-bold text-[10px]">{{ $isEn ? 'Article' : 'مقال' }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 font-bold py-2">{{ $isEn ? 'No article results found' : 'لا توجد نتائج في المقالات' }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Users Results --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary flex items-center justify-between">
                        <span>{{ $isEn ? 'Registered Users' : 'المستخدمين المسجلين' }} ({{ $users->count() }})</span>
                        <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
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
                            <p class="text-xs text-gray-400 font-bold py-2">{{ $isEn ? 'No user results found' : 'لا توجد نتائج في المستخدمين' }}</p>
                        @endforelse
                    </div>
                </div>

            </div>
        @endif

    </div>
</x-admin-layout>
