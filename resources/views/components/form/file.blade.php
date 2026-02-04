@props([
    'label' => null,
    'name'
])

@php
    $hasError = $errors->has($name);
@endphp

<div class="space-y-2">
    @if ($label)
        <label class="block text-xs font-bold uppercase tracking-wide
            {{ $hasError ? 'text-red-500' : 'text-purple-600' }}">
            {{ $label }}
        </label>
    @endif

    <input
        type="file"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'text-sm'
        ]) }}
    />

    @error($name)
        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>
