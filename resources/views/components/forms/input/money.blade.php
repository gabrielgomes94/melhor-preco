<div class="form-group w-100">
    <label for="">{{ $label }} (R$)</label>
    <input
        type="text"
        class="form-control w-100 input-money"
        id="{{ $id  }}-input-view"
        name="{{ $name }}"
        value="{{ $value }}"
    >

    <input
        type="hidden"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
    >
</div>
