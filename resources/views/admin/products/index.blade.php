@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Medical Devices & Products Management' : 'إدارة المتجر والمنتجات الطبية' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Medical Devices & Inventory Stock Management' : 'إدارة الأجهزة والمستلزمات الطبية بالمخزون' }}</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-5 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Flash Success Alert --}}
        @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-base text-primary">{{ $isEn ? 'Products & Supplies Catalog' : 'كتالوج المنتجات والمستلزمات' }} ({{ $products->total() }})</h3>
                <p class="text-xs text-gray-500">{{ $isEn ? 'Monitor stored devices, stock levels, prices, and perform modifications' : 'متابعة الأجهزة المخزنة والكميات والأسعار والتعديل عليها' }}</p>
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="bg-accent hover:bg-accent-hover text-white py-2.5 px-4 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $isEn ? 'Add New Product' : 'إضافة منتج طبي جديد' }}</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">#</th>
                        <th class="p-3">{{ $isEn ? 'SKU Code' : 'رمز SKU' }}</th>
                        <th class="p-3">{{ $isEn ? 'Product Name' : 'اسم المنتج الطبي' }}</th>
                        <th class="p-3">{{ $isEn ? 'Category' : 'التصنيف' }}</th>
                        <th class="p-3">{{ $isEn ? 'Available Stock' : 'المخزون المتوفر' }}</th>
                        <th class="p-3">{{ $isEn ? 'Base Price' : 'السعر الأساسي' }}</th>
                        <th class="p-3">{{ $isEn ? 'Discounted Price' : 'السعر المخصوم' }}</th>
                        <th class="p-3">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                        <th class="p-3 text-center">{{ $isEn ? 'Actions & Controls' : 'الإجراءات والعمليات' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-bold text-gray-400">{{ $p->id }}</td>
                            <td class="p-3 font-black text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $p->sku }}</td>
                            <td class="p-3 font-black text-primary">{{ $p->title }}</td>
                            <td class="p-3 font-bold text-gray-600">{{ $p->category->name ?? ($isEn ? 'Supplies' : 'مستلزمات') }}</td>
                            <td class="p-3 font-black {{ $p->stock > 10 ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $p->stock }} {{ $isEn ? 'pcs' : 'قطعة' }}
                            </td>
                            <td class="p-3 font-bold text-gray-800 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($p->price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</td>
                            <td class="p-3 font-black text-accent dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                                {{ $p->discount_price > 0 ? number_format($p->discount_price, 2) . ' ' . ($isEn ? 'SAR' : 'ر.س') : '-' }}
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $p->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $p->is_active ? ($isEn ? 'Published' : 'معروض بالمحتوى') : ($isEn ? 'Hidden' : 'مخفي') }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.products.edit', $p->id) }}" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors font-bold flex items-center gap-1 text-[11px]" title="{{ $isEn ? 'Edit Product' : 'تعديل المنتج' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $isEn ? 'Edit' : 'تعديل' }}</span>
                                    </a>

                                    {{-- Delete Button Form --}}
                                    <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('{{ $isEn ? 'Are you sure you want to permanently delete this product?' : 'هل أنت تأكد من رغبتك في حذف هذا المنتج الطبي نهائياً؟' }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors font-bold flex items-center gap-1 text-[11px]" title="{{ $isEn ? 'Delete Product' : 'حذف المنتج' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>{{ $isEn ? 'Delete' : 'حذف' }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $products->links() }}
        </div>

    </div>
</x-admin-layout>
