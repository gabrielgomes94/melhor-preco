<div class="form-group w-100">
    @isset($label)
        <label for="{{ $componentId }}">{{ $label }}</label>
    @endisset

    <input
        type="text"
        class="form-control w-100"
        id="{{ $componentId }}"
        name="{{ $attribute }}"
        value="{{ $value }}"
        readonly
    >
</div>

