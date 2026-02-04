@props([
    'label' => null,
    'type' => 'text',
    'name',
    'placeholder' => '',
])

@php
    $hasError = $errors->has($name);
@endphp

<div class="space-y-1">
    @if ($label)
        <label for="{{ $name }}"
            class="block text-xs font-bold uppercase tracking-wide
            {{ $hasError ? 'text-red-500' : 'text-zinc-600' }}">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        type="{{ $type }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-xl border px-4 py-2.5 text-sm transition
                        focus:ring-2 focus:outline-none
                        ' . ($hasError
                            ? 'border-red-400 focus:ring-red-200'
                            : 'border-zinc-200 focus:border-purple-500 focus:ring-purple-200')
        ]) }}
    />

    {{-- Error Message --}}
    @error($name)
        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>
