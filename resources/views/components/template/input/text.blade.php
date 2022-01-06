<div class="form-group w-100">
    @isset($label)
        <label for="{{ $visibleComponentId }}">{{ $label }}</label>
    @endisset

    <input
        type="text"
        class="form-control w-100 input-text"
        id="{{ $visibleComponentId  }}"
        name="{{ $attribute }}"
        value="{{ $value }}"
    >
</div>
