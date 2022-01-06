<div class="form-group w-100">
    @isset($label)
        <label for="{{ $visibleComponentId }}">{{ $label }} (%)</label>
    @endisset

    <input
        type="text"
        class="form-control w-100 input-percentage"
        id="{{ $visibleComponentId  }}"
        name="{{ $attribute }}"
        value="{{ $value }}"
    >

        @if (!$simpleInput)
            <input
                type="hidden"
                id="{{ $componentId }}"
                name="{{ $attribute }}"
                value="{{ $value }}"
            >
        @endif
</div>

