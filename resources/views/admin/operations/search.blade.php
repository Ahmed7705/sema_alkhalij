@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Advanced Operational Search - Operations Center' : 'البحث التشغيلي المتقدم - مركز العمليات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Advanced Operational Search & Tracking Center for Medical Visits & Samples' : 'مركز البحث والتتبع التشغيلي المتقدم للعمليات الطبية والعينات' }}</x-slot>

    @livewire('admin.advanced-operations-search')
</x-admin-layout>
