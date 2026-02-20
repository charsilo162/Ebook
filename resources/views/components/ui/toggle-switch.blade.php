@props([
    'checked' => false,
])

<button
    type="button"
    {{ $attributes }}
    class="relative inline-flex h-6 w-11 items-center rounded-full transition duration-300
           {{ $checked ? 'bg-green-600' : 'bg-zinc-300' }}"
>
    <span
        class="inline-block h-4 w-4 transform rounded-full bg-white transition duration-300
        {{ $checked ? 'translate-x-6' : 'translate-x-1' }}"
    ></span>
</button>
