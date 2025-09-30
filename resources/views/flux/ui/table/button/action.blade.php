@props(['id' => null, 'showEdit' => true, 'showDelete' => true, 'showDetail' => true, 'detailRoute' => null])
<flux:button.group>
    @if ($showDetail)
        <flux:modal.trigger>
            <flux:button size="sm" wire:navigate
             href="{{ $detailRoute }}" icon="eye">Detail</flux:button>
        </flux:modal.trigger>
    @endif

    @if ($showEdit)
        <flux:modal.trigger name="edit" wire:click="edit({{ $id }})">
            <flux:button size="sm" icon="pencil">Edit</flux:button>
        </flux:modal.trigger>
    @endif

    @if ($showDelete)
        <flux:modal.trigger name="confirmDelete" wire:click="confirmDelete({{ $id }})">
            <flux:button size="sm" variant="danger" icon="trash">Delete
            </flux:button>
        </flux:modal.trigger>
    @endif

    {{ $slot }}
</flux:button.group>
