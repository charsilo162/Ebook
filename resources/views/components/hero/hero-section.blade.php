<section
    x-data="{ show: false }"
    x-init="
        requestAnimationFrame(() => {
            show = true
        })
    "
    x-cloak
    class="relative min-h-[80vh] flex items-center bg-cover bg-center overflow-hidden"
    style="background-image:url('{{ asset('storage/images/p2.jpg') }}')"
>

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/70
               transition-opacity duration-700"
        :class="show ? 'opacity-100' : 'opacity-0'"
    ></div>

    {{-- Content --}}
    <div class="relative w-full px-6 md:px-12 text-white">
        <div class="max-w-5xl space-y-4">

            {{-- Headline --}}
            <h1 class="text-3xl md:text-5xl font-bold leading-tight text-left space-y-2">
                <span
                    class="block transition-all duration-700 ease-out"
                    :class="show
                        ? 'opacity-100 translate-x-0 blur-0'
                        : 'opacity-0 -translate-x-8 blur-sm'
                    "
                >
                    READERS ARE LEADERS
                </span>

                <span
                    class="block transition-all duration-700 delay-150 ease-out"
                    :class="show
                        ? 'opacity-100 translate-x-0 blur-0'
                        : 'opacity-0 -translate-x-8 blur-sm'
                    "
                >
                    READERS CONCEIVE IDEAS FOR TOMORROW
                </span>

                <span
                    class="block transition-all duration-700 delay-300 ease-out"
                    :class="show
                        ? 'opacity-100 translate-x-0 blur-0'
                        : 'opacity-0 -translate-x-8 blur-sm'
                    "
                >
                    GEMS ARE HARVESTED AND WRAPPED IN A BOOK
                </span>
            </h1>

            {{-- Description --}}
            <p
                class="text-lg text-left max-w-2xl transition-all duration-700 delay-450 ease-out"
                :class="show
                    ? 'opacity-90 translate-x-0'
                    : 'opacity-0 -translate-x-6'
                "
            >
                We have a growing statistic of 234,239,093 books in both ebook and hard copy
            </p>

            {{-- Search --}}
            <div
                class="mt-6 max-w-2xl transition-all duration-700 delay-600 ease-out"
                :class="show
                    ? 'opacity-100 scale-100'
                    : 'opacity-0 scale-95'
                "
            >
                <x-ui.search-input
                    placeholder="Search books by name, category or author"
                />
            </div>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-3 mt-6">
                {{ $slot }}
            </div>

        </div>
    </div>
</section>
