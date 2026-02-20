<section class="relative bg-gradient-to-b from-white to-zinc-50 border-t border-zinc-200/60">
    <div class="max-w-7xl mx-auto px-6 py-20">

        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h3 class="text-3xl md:text-4xl font-semibold tracking-tight text-zinc-900">
                Trusted by Readers & Authors
            </h3>
            <p class="mt-4 text-zinc-500 text-base">
                Premium service, secure transactions, and a seamless reading experience.
            </p>
        </div>

        {{-- Features --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            @foreach ($items as $item)
                <div
                    class="group relative bg-white/70 backdrop-blur-xl
                           border border-zinc-200/60
                           rounded-2xl p-8
                           transition-all duration-500
                           hover:-translate-y-2 hover:shadow-xl"
                >

                    {{-- Soft Glow Effect --}}
                    <div class="absolute inset-0 rounded-2xl opacity-0 
                                group-hover:opacity-100 transition duration-500
                                bg-gradient-to-br from-purple-500/5 to-indigo-500/5">
                    </div>

                    {{-- Icon --}}
                    <div class="relative mb-6 flex justify-center">
                        <div class="h-14 w-14 rounded-2xl
                                    bg-gradient-to-br from-purple-600 to-indigo-600
                                    text-white flex items-center justify-center
                                    shadow-lg group-hover:scale-110
                                    transition duration-300">

                            @switch($item['icon'])
                                @case('delivery')
                                    <x-heroicon-o-truck class="h-6 w-6" />
                                    @break

                                @case('secure')
                                    <x-heroicon-o-lock-closed class="h-6 w-6" />
                                    @break

                                @case('support')
                                    <x-heroicon-o-chat-bubble-left-right class="h-6 w-6" />
                                    @break
                            @endswitch

                        </div>
                    </div>

                    {{-- Title --}}
                    <h4 class="relative text-lg font-semibold text-zinc-900 text-center">
                        {{ $item['title'] }}
                    </h4>

                    {{-- Description --}}
                    <p class="relative mt-3 text-zinc-500 text-sm text-center leading-relaxed">
                        {{ $item['description'] }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
</section>
