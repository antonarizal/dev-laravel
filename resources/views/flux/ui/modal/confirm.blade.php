<flux:modal wire:model.self="showConfirmModal" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Hapus data ini?</flux:heading>
            <flux:subheading>
                <p>Data yang dihapus tidak dapat dikembalikan</p>
                <flux:input type="hidden" wire:model="data_id" />
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button variant="danger" wire:click="delete()">Delete</flux:button>
        </div>
    </div>
</flux:modal>
