<div class="form-group w-100">
    @isset($label)
        <label for="{{ $componentId  }}-input-view">{{ $label }} (R$)</label>
    @endisset

    <input
        type="text"
        class="form-control w-100 input-money"
        id="{{ $componentId  }}-input-view"
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
