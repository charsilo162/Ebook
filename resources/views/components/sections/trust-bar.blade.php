<section class="border-t border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- Section Header --}}
        <div class="mb-10 text-center">
            <h3 class="text-2xl font-bold text-gray-900">
                Why Shop With Us
            </h3>
            <p class="mt-2 text-gray-500 text-sm max-w-xl mx-auto">
                Enjoy fast delivery, secure payments, and dedicated customer support.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            @foreach ($items as $item)
                <div class="rounded-xl border border-gray-100 p-6 hover:shadow-md transition">

                    {{-- Icon --}}
                    <div class="mb-4 flex justify-center">
                        <div class="h-12 w-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
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

                    <h4 class="font-semibold text-gray-900 text-sm uppercase tracking-wide">
                        {{ $item['title'] }}
                    </h4>

                    <p class="mt-2 text-gray-500 text-sm">
                        {{ $item['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>
