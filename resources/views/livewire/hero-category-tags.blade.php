<div class="flex flex-wrap items-center justify-center gap-3"> 
    @foreach ($categories as $index => $category)
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            style="transition-delay: {{ (int)$index * 120 }}ms"
        >
            <a 
                href="/categories?category={{ $category['uuid'] }}"
                class="group inline-block p-1 cursor-pointer transition-all duration-300 ease-in-out text-black hover:-translate-y-1 hover:scale-105 hover:bg-blue-600 hover:text-black hover:shadow-lg rounded-full active:scale-95"
            >
                <x-ui.pill-button
                    :label="$category['name']"
                    :color="$colors[(int)$index % count($colors)]"
                    class="text-black group-hover:bg-blue-600 group-hover:text-black transition-colors duration-300"
                />
            </a>
        </div>
    @endforeach
</div>