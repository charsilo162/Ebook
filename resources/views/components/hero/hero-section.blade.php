<section
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 100)"
    class="relative min-h-[80vh] flex items-center bg-cover bg-center overflow-hidden"
    style="background-image:url('{{ asset('storage/images/p2.jpg') }}')"
>

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/60"
        x-show="show"
        x-transition.opacity.duration.700ms
    ></div>

    {{-- Content Wrapper (LEFT ALIGNED) --}}
    <div class="relative w-full px-6 md:px-12 text-white">
        <div class="max-w-5xl">

            {{-- Heading (3 lines only) --}}
            <h1
                x-show="show"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="text-3xl md:text-5xl font-bold leading-tight text-left"
            >
                READERS ARE LEADERS<br>
                READERS CONCEIVE IDEAS FOR TOMORROW<br>
                GEMS ARE HARVESTED AND WRAPPED IN A BOOK
            </h1>

            {{-- Description --}}
            <p
                x-show="show"
                x-transition:enter="transition ease-out delay-150 duration-700"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-90 translate-y-0"
                class="mt-4 text-lg text-left max-w-2xl"
            >
                We have a growing statistic of 234,239,093 books in both ebook and hard copy
            </p>

            {{-- Search --}}
            <div
                x-show="show"
                x-transition:enter="transition ease-out delay-300 duration-700"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="mt-6 max-w-2xl"
            >
                <x-ui.search-input
                    placeholder="Search books by name, category or author"
                />
            </div>

            {{-- Tags (Left-aligned, staggered) --}}
            <div class="flex flex-wrap gap-3 mt-6">
                {{ $slot }}
            </div>

        </div>
    </div>
</section>
