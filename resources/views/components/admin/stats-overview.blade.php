@props([
    'stats' => []
])

<section class="mt-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($stats as $stat)
            <x-ui.stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :icon="$stat['icon'] ?? null"
                :color="$stat['color'] ?? 'zinc'"
            />
        @endforeach
    </div>
</section>
