<div class="flex flex-wrap items-center justify-center gap-3"> 
    @foreach ($categories as $index => $category)
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            style="transition-delay: {{ (int)$index * 120 }}ms"
        >
            <a href="/categories?category={{ $category['uuid'] }}">
                <x-ui.pill-button
                    :label="$category['name']"
                    :color="$colors[(int)$index % count($colors)]"
                />
            </a>
        </div>
    @endforeach
</div>