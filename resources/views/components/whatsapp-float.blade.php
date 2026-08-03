{{-- WhatsApp Floating Button - Official Style --}}
<div class="fixed bottom-8 left-8 z-40" x-data="{ tooltip: false }">
    <a href="https://wa.me/966545880082?text={{ urlencode('السلام عليكم، أود الاستفسار عن خدمات سيما الخليج الطبية المنزلية') }}"
       target="_blank"
       rel="noopener noreferrer"
       @mouseenter="tooltip = true"
       @mouseleave="tooltip = false"
       class="block w-[60px] h-[60px] bg-[#25D366] rounded-full flex items-center justify-center shadow-[0_6px_24px_rgba(37,211,102,0.45)] hover:shadow-[0_8px_32px_rgba(37,211,102,0.6)] hover:scale-110 transition-all duration-300 relative"
       title="تواصل عبر الواتساب">

        {{-- Official WhatsApp SVG Icon --}}
        <svg class="w-[34px] h-[34px]" viewBox="0 0 32 32" fill="white">
            <path d="M16.004 0h-.008C7.174 0 0 7.176 0 16.004c0 3.502 1.14 6.742 3.068 9.372L1.06 31.44l6.256-2.002c2.51 1.7 5.574 2.692 8.688 2.692C24.826 32.13 32 24.954 32 16.126 32 7.298 24.826 0 16.004 0zm9.35 22.614c-.396 1.116-2.298 2.136-3.2 2.218-.814.074-1.846.106-2.978-.188a27.14 27.14 0 01-2.694-.996c-4.746-2.046-7.846-6.846-8.086-7.166-.232-.32-1.9-2.53-1.9-4.826s1.2-3.424 1.628-3.892c.428-.468.936-.584 1.248-.584.312 0 .624.004.898.016.288.014.674-.11.982.748.32.89 1.088 2.652 1.184 2.844.096.192.16.418.032.672-.128.254-.192.414-.384.638-.192.224-.404.5-.576.672-.192.192-.394.4-.168.786.224.384 1.002 1.654 2.152 2.68 1.478 1.318 2.724 1.726 3.108 1.918.384.192.608.16.832-.096.224-.256.96-1.118 1.216-1.502.256-.384.512-.32.864-.192.352.128 2.226 1.05 2.608 1.242.384.192.638.288.732.448.096.16.096.926-.3 2.042z"/>
        </svg>

        {{-- Pulse ring --}}
        <span class="absolute inset-0 rounded-full border-2 border-[#25D366] animate-ping opacity-30 pointer-events-none"></span>
    </a>

    {{-- Tooltip --}}
    <div x-show="tooltip" x-transition.duration.200ms
         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded-xl whitespace-nowrap shadow-lg pointer-events-none">
        تحدث معنا على الواتساب 💬
        <div class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45 -mt-1"></div>
    </div>
</div>
