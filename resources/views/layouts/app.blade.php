<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'سيما الخليج للخدمات الطبية | الرعاية الصحية المنزلية المتقدمة' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'سيما الخليج للخدمات الطبية - نقدم أحدث خدمات الرعاية الصحية المنزلية في المملكة العربية السعودية: زيارات طبية، تمريض، علاج طبيعي، فحوصات مخبرية، ومتجر مستلزمات طبية.' }}">
    <meta name="keywords" content="رعاية صحية منزلية, تمريض منزلي, علاج طبيعي, زيارة طبيب منزلي, فحوصات مخبرية منزلية, جدة, السعودية, سيما الخليج">

    <!-- Open Graph / Facebook / Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'سيما الخليج للخدمات الطبية' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'أحدث خدمات الرعاية الصحية المنزلية في المملكة العربية السعودية.' }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts (Tajawal & Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine.js Collapse Plugin (for FAQ accordion) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine.js Intersect Plugin (for scroll animations) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles

    <!-- Structured Data Schema.org -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalOrganization",
      "name": "شركة سيما الخليج للخدمات الطبية",
      "alternateName": "Seema Al-Khalij Medical Services",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('images/logo.png') }}",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+966545880082",
        "contactType": "customer service",
        "areaServed": "SA",
        "availableLanguage": ["Arabic", "English"]
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "طريق المدينة المنورة، حي الرويس",
        "addressLocality": "جدة",
        "addressCountry": "SA"
      },
      "sameAs": [
        "https://wa.me/966545880082"
      ]
    }
    </script>

    @stack('styles')
</head>
<body class="bg-surface text-darktext antialiased font-sans min-h-screen flex flex-col justify-between" x-data="{ callbackModalOpen: false, searchOpen: false, selectedService: '' }">

    <!-- Navbar / Header -->
    <x-header />

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Sticky Floating Action Buttons -->
    <x-whatsapp-float />

    <!-- Request Callback Modal -->
    <x-callback-modal />

    <!-- Cookie Consent Banner -->
    <x-cookie-banner />

    @livewireScripts
    @stack('scripts')
</body>
</html>
