<div class="form-group w-100">
    @isset($label)
        <label for="{{ $componentId }}">{{ $label }}</label>
    @endisset

    <input
        type="hidden"
        class="form-control w-100 {{ $class ?? '' }}"
        id="{{ $componentId }}"
        name="{{ $name ?? '' }}"
        value="{{ $value ?? '' }}"
        readonly
    >
</div>

