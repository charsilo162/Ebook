@props([
    'label',
    'color' => 'zinc',
])

@php
$colors = [
    'zinc' => 'bg-zinc-100 text-zinc-900',
    'blue' => 'bg-blue-100 text-blue-900',
    'green' => 'bg-green-100 text-green-900',
    'pink' => 'bg-pink-100 text-pink-900',
    'red' => 'bg-red-100 text-red-900',
];

$classes = $colors[$color] ?? $colors['zinc'];
@endphp

<button
    {{ $attributes->merge([
        'class' =>
        'px-6 py-2 rounded-full text-sm font-medium
         transition-all duration-200
         hover:-translate-y-0.5 hover:shadow-md
         active:scale-95 ' . $classes
    ]) }}
>
    {{ $label }}
</button>

