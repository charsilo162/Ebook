@php
    $stats = [
        [
            'label' => 'Total Books',
            'value' => number_format($totalBooks),
            'color' => 'blue',
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24"><path d="M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14"/></svg>',
        ],
        [
            'label' => 'Books Purchased',
            'value' => number_format($totalPurchased),
            'color' => 'green',
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/></svg>',
        ],
        [
            'label' => 'Soft Copies',
            'value' => number_format($softCopies),
            'color' => 'purple',
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24"><path d="M12 4v16"/></svg>',
        ],
        [
            'label' => 'Hard Copies',
            'value' => number_format($hardCopies),
            'color' => 'orange',
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24"><path d="M4 6h16v12H4z"/></svg>',
        ],
    ];
@endphp

<x-admin.stats-overview :stats="$stats" />
