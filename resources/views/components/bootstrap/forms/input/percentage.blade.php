<div class="form-group w-100">
    @isset($label)
        <label for="{{ $id }}-input-view">{{ $label }}</label>
    @endisset

    <input type="text"
           class="form-control w-100 input-percentage"
           id="{{ $id  }}-input-view"
           name="{{ $name }}"
           value="{{ $value }}"
    >

    <input type="hidden"
           id="{{ $id }}"
           name="{{ $name }}"
           value="{{ $value }}"
    >
</div>

