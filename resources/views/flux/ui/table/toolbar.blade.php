@props(
    [
        'showCreateButton' => false,
        'showDeleteButton' => false,
        'search' => '',
        'sortField' => 'id',
        'sortDirection' => 'desc',
    ]
)
<div class="flex justify-between items-center mb-4">
    <!-- Input Search -->
    <div class="w-1/3">
        <p class="mb-3">
            <flux:input size="sm" icon="magnifying-glass" placeholder="Search" wire:model.live="search" clearable />
            <flux:input type="hidden" wire:model.live="sortDirection" />
            <flux:input type="hidden" wire:model.live="sortField" />
        </p>
        <p class="mt-3 {{ $showDeleteButton ? '' : 'hidden' }}">
            <flux:button size="sm" variant="danger" wire:click="deleteSelected"
                wire:confirm="Yakin menghapus data ini?">Delete Selected
            </flux:button>
        </p>
    </div>
    @if($showCreateButton)
        <flux:button size="sm" icon="plus" variant="primary" wire:click="create">Tambah</flux:button>
    @endif
</div>
