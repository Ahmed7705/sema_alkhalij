<button wire:click="$emit('openCart')" @click="cartOpen = true" class="p-2.5 text-gray-500 hover:text-primary hover:bg-medical-50 rounded-xl transition-all relative" title="{{ app()->getLocale()=='en' ? 'Shopping Cart' : 'سلة التسوق' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
    </svg>
    
    @if($cartCount > 0)
        <span class="absolute -top-0.5 -right-0.5 bg-accent text-white font-black text-[10px] min-w-4 h-4 px-1 rounded-full flex items-center justify-center border-2 border-white shadow-sm animate-pulse dir-ltr">
            {{ $cartCount }}
        </span>
    @endif
</button>
