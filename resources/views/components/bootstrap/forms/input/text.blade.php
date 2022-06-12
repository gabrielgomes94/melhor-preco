<div class="form-group w-100">
    <label for="{{ $id ?? '' }}">{{ $label ?? '' }}</label>

    <input
        type="text"
        class="form-control w-100 input-text"
        id="{{ $id ?? ''  }}"
        name="{{ $attribute ?? '' }}"
        value="{{ $value ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}"
    >
</div>
