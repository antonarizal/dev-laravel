@props(['name','label', 'placeholder','type'])

<flux:input type="{{ $type }}" label="{{ $label ?? $label }}" placeholder="{{ $placeholder ?? $label }}" wire:model="{{ strtolower($name) }}" />
