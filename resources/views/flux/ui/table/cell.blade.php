@props(['showCheckBox' => false, 'id' => null])
@if ($showCheckBox)

<td class="w-4 p-4">
    <div class="flex items-center">
        <flux:checkbox wire:click="selectAll" value="{{ $id }}" />
    </div>
</td>

@else
<td class="px-2 py-2 " {{ $attributes }}>
    {{ $slot }}
</td>
@endif

