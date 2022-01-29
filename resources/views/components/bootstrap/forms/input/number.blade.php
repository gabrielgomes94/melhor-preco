<div class="form-group w-100">
    @isset($label)
        <label for="{{ $id }}-input-view">{{ $label }}</label>
    @endisset

    <input type="number"
           class="form-control w-100 {{ $class }}"
           step=".01"
           name="{{ $name }}"
           id="{{ $id  }}-input-view"
           value="{{ $value }}"
    >
</div>

