@props(['name','field','label', 'placeholder','options'])
<flux:select size="sm" label="{{ $label ?? $label }}" placeholder="{{ $placeholder ?? $label }}" wire:model="{{ ($name) }}">
    @foreach ($options as $row)
        <flux:select.option value="{{ $row->id }}">{{ $row->$field }}</flux:select.option>
    @endforeach
</flux:select>
