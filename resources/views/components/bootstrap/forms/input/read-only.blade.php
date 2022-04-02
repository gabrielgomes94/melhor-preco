<div class="form-group w-100">
    @isset($label)
        <label for="{{ $id ?? '' }}">{{ $label }}</label>
    @endisset

    <input
        type="text"
        class="form-control w-100"
        id="{{ $id ?? ''}}"
        name="{{ $name ?? '' }}"
        value="{{ $value ?? '' }}"
        readonly
    >
</div>

