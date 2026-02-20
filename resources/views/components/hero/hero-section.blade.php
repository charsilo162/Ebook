<section
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 100)"
    x-cloak
    class="relative min-h-[90vh] flex items-center overflow-hidden bg-black"
>

    {{-- Background Image --}}
    <div class="absolute inset-0">
        <img 
            src="{{ asset('storage/images/p2.jpg') }}"
            class="w-full h-full object-cover scale-110 transition-transform duration-[6s] ease-out"
            :class="show ? 'scale-100' : 'scale-110'"
        >

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/40"></div>
    </div>

    {{-- Floating Feature Card (on image) --}}
    <div 
        class="hidden lg:block absolute right-12 top-1/2 -translate-y-1/2
               bg-white/10 backdrop-blur-xl border border-white/20
               rounded-2xl p-6 w-72 text-white shadow-2xl
               transition-all duration-700"
        :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
    >
        <h3 class="text-lg font-semibold mb-3">Why Choose Us</h3>
        <ul class="space-y-2 text-sm text-white/80">
            <li>✔ 200M+ Books Available</li>
            <li>✔ Instant Ebook Download</li>
            <li>✔ Verified Authors</li>
            <li>✔ Premium Hard Copies</li>
        </ul>
    </div>

    {{-- Main Content --}}
    <div class="relative w-full px-6 md:px-12 text-white">
        <div class="max-w-4xl space-y-6">

            {{-- Headline --}}
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">

                <span
                    class="block transition-all duration-700 ease-out"
                    :class="show 
                        ? 'opacity-100 translate-y-0' 
                        : 'opacity-0 translate-y-6'"
                >
                    Readers Are Leaders
                </span>

                <span
                    class="block text-purple-400 transition-all duration-700 delay-150 ease-out"
                    :class="show 
                        ? 'opacity-100 translate-y-0' 
                        : 'opacity-0 translate-y-6'"
                >
                    Ideas For Tomorrow
                </span>

                <span
                    class="block text-white/70 text-2xl md:text-3xl mt-2 font-medium
                           transition-all duration-700 delay-300 ease-out"
                    :class="show 
                        ? 'opacity-100 translate-y-0' 
                        : 'opacity-0 translate-y-6'"
                >
                    Gems Wrapped In Books
                </span>

            </h1>

            {{-- Description --}}
            <p
                class="text-lg text-white/80 max-w-2xl transition-all duration-700 delay-500"
                :class="show 
                    ? 'opacity-100 translate-y-0' 
                    : 'opacity-0 translate-y-4'"
            >
                Explore over <span class="font-semibold text-white">234,239,093+</span> 
                ebooks and premium hard copies from verified authors worldwide.
            </p>

            {{-- CTA Buttons --}}
            <div
                class="flex flex-wrap gap-4 mt-6 transition-all duration-700 delay-700"
                :class="show 
                    ? 'opacity-100 scale-100' 
                    : 'opacity-0 scale-95'"
            >
                <a href="{{ route('category.books') }}" 
                   class="px-6 py-3 bg-purple-600 hover:bg-purple-700
                          rounded-xl shadow-lg transition duration-300">
                    Browse Books
                </a>
 @php
        $user = Session::get('user');
    @endphp

    @if(!$user)
                <a href="{{ route('signup') }}"
                   class="px-6 py-3 border border-white/30 hover:bg-white/10
                          rounded-xl transition duration-300">
                    Become a Vendor
                </a>
                @endif
            </div>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-3 mt-6">
                {{ $slot }}
            </div>

        </div>
    </div>

</section>

