@props([
    'label' => null,
    'field',
    'sortField' => 'id',
    'sortDirection' => 'desc',
    'sortable' => false
])

<th {{ $attributes->merge(['class' => 'px-4 py-2 cursor-pointer']) }}
    @if($sortable)
        wire:click="sortBy('{{ $field }}')"
    @endif
>
    <div class="flex items-center gap-2">
        {{ $label }}
        @if($sortable && $field == $sortField)
            @if ($sortDirection == 'desc')
                <flux:icon.chevron-up variant="micro" />
            @else
                <flux:icon.chevron-down variant="micro" />
            @endif
        @endif
    </div>
</th>
