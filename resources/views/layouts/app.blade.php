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
    <style>[x-cloak] { display: none !important; }</style>

    {{-- ✦ GLOBAL DIRECTION RESET ✦ --}}
    @if(app()->getLocale() == 'en')
    <style>
        html, body {
            direction: ltr !important;
            text-align: left !important;
            font-family: 'Inter', 'Tajawal', sans-serif !important;
        }
        .text-center { text-align: center !important; }
        .text-right  { text-align: right !important; }
        .text-left   { text-align: left !important; }
        .dir-ltr     { direction: ltr; text-align: left; }
    </style>
    @else
    <style>
        html, body {
            direction: rtl !important;
            text-align: right !important;
            font-family: 'Tajawal', 'Inter', sans-serif !important;
        }
        .text-center { text-align: center !important; }
        .text-right  { text-align: right !important; }
        .text-left   { text-align: left !important; }
        .dir-ltr     { direction: ltr; text-align: left; }
    </style>
    @endif

    <!-- Alpine.js Plugins (MUST be loaded BEFORE Alpine Core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
    <script>
        window.emitLivewire = function(event, ...args) {
            try {
                if (window.Livewire && typeof window.Livewire.emit === 'function') {
                    window.Livewire.emit(event, ...args);
                } else if (typeof Livewire !== 'undefined' && typeof Livewire.emit === 'function') {
                    Livewire.emit(event, ...args);
                } else {
                    document.addEventListener('livewire:load', function () {
                        if (window.Livewire && typeof window.Livewire.emit === 'function') {
                            window.Livewire.emit(event, ...args);
                        }
                    }, { once: true });
                }
            } catch (e) {
                console.warn('Livewire notice:', e);
            }
        };
    </script>

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
<body class="bg-surface text-darktext antialiased font-sans min-h-screen flex flex-col justify-between" 
      x-data="{ 
          callbackModalOpen: false, 
          searchOpen: false, 
          selectedService: '',
          cartOpen: false,
          checkoutOpen: false,
          cart: [],
          addToCart(product) {
              let existing = this.cart.find(i => i.id === product.id);
              if (existing) {
                  existing.qty += (product.qty || 1);
              } else {
                  this.cart.push({
                      id: product.id,
                      title: product.title,
                      price: product.price,
                      img: product.img,
                      qty: product.qty || 1
                  });
              }
              this.cartOpen = true;
          },
          removeFromCart(id) {
              this.cart = this.cart.filter(i => i.id !== id);
          },
          updateQty(id, delta) {
              let item = this.cart.find(i => i.id === id);
              if (item) {
                  item.qty += delta;
                  if (item.qty <= 0) this.removeFromCart(id);
              }
          },
          get cartSubtotal() {
              return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
          },
          get cartCount() {
              return this.cart.reduce((sum, item) => sum + item.qty, 0);
          }
      }">

    <!-- Navbar / Header -->
    <x-header />

    <!-- Main Content -->
    <main class="flex-grow">
        {!! $slot ?? $__env->yieldContent('content') !!}
    </main>


    <!-- Shopping Cart Drawer & Checkout Component -->
    @include('components.cart-drawer')

    <!-- Footer -->
    <x-footer />

    <!-- Sticky Floating Action Buttons -->
    <x-whatsapp-float />

    <!-- Request Callback Modal -->
    <x-callback-modal />

    <!-- Livewire Service Booking Modal Wizard -->
    @livewire('service-booking-modal')

    <!-- Livewire Shopping Cart Drawer -->
    @livewire('cart-drawer')

    <!-- Cookie Consent Banner -->
    <x-cookie-banner />

    <!-- Livewire Published Static Script (Ensures Livewire class exists on production hosting) -->
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
