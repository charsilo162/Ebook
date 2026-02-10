@props([
    'image',
    'title',
    'subtitle' => null,
    'meta' => [],
    'description' => null,
    'tags' => [],
    'actions' => null,
])

<section class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-purple-500 to-indigo-600">

    {{-- Decorative blur --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-16">

        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-10
                   bg-white/95 backdrop-blur rounded-2xl
                   shadow-xl ring-1 ring-black/5 p-8 md:p-10"
        >

            {{-- Image card --}}
            <div class="relative md:pr-6">
                <div class="relative overflow-hidden rounded-2xl
                            bg-white shadow-lg ring-1 ring-black/5
                            p-3">
                    <img
                        src="{{ asset($image) }}"
                        alt="{{ $title }}"
                        class="w-full aspect-[4/5] rounded-xl object-cover"
                    />
                </div>
            </div>

            {{-- Content --}}
            <div class="flex flex-col justify-center space-y-8 md:space-y-10 md:pl-6">

                {{-- Subtitle --}}
                @if ($subtitle)
                    <span class="inline-block w-fit px-3 py-1 text-xs font-semibold rounded-full
                                 bg-purple-100 text-purple-700 uppercase tracking-wide">
                        {{ $subtitle }}
                    </span>
                @endif

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">
                   <span class="text-purple-600">TITLE </span> :  {{ $title }}
                </h1>

                {{-- Meta --}}
                @if (!empty($meta))
                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-zinc-500">
                        @foreach ($meta as $item)
                            <span>{{ $item }}</span>
                        @endforeach
                    </div>
                @endif

                {{-- Description --}}
                @if ($description)
                    <p class="text-zinc-600 leading-relaxed max-w-xl">
                      <span class="text-purple-600">DESCRIPTION </span> :  {{ $description }}
                    </p>
                @endif

                {{-- Tags --}}
                @if (!empty($tags))
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <x-ui.pill-button
                                :label="$tag['label']"
                                :color="$tag['color'] ?? 'zinc-800'"
                            />
                        @endforeach
                    </div>
                @endif

                {{-- Actions --}}
                @if ($actions)
                    <div class="pt-6 flex gap-4">
                        {{ $actions }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
