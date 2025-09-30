@props(['show', 'message'])
<flux:modal wire:model.self="showErrorModal" class="fixed top-5 right-5 min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">
                <div class="flex items-center gap-2">
                    <flux:icon.x-circle class="text-red-600 dark:text-red-500" />
                    <span class="text-sm text-red-600 dark:text-red-500">Gagal</span>
                </div>
            </flux:heading>
            <flux:subheading>
                <p> {{ $message }}</p>
                <flux:input type="hidden" wire:model="data_id" />
            </flux:subheading>
        </div>

        {{-- <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Tutup</flux:button>
            </flux:modal.close>
        </div> --}}
    </div>
</flux:modal>
