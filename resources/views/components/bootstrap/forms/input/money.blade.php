<div class="form-group w-100">
    @isset($label)
        <label for="{{ $componentId ?? $id }}-input-view">{{ $label }} (R$)</label>
    @endisset

    <input
        type="text"
        class="form-control w-100 input-money"
        id="{{ $componentId ?? $id }}-input-view"
        name="{{ $attribute ?? $name }}"
        value="{{ $value ?? '' }}"
    >

    <input
        type="hidden"
        id="{{ $componentId ?? $id }}"
        name="{{ $attribute ?? $name }}"
        value="{{ $value ?? '' }}"
    >
</div>
