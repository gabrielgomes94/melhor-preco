<div class="form-group w-100">
    @isset($label)
        <label for="{{ $visibleComponentId }}">{{ $label }} (R$)</label>
    @endisset

    <input
        type="text"
        class="form-control w-100 input-money"
        id="{{ $visibleComponentId  }}"
        name="{{ $attribute }}"
        value="{{ $value }}"
    >

    <input
        type="hidden"
        id="{{ $componentId }}"
        name="{{ $attribute }}"
        value="{{ $value }}"
    >
</div>
