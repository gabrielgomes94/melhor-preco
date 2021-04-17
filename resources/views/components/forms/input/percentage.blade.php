<div class="form-group w-100">
    <label for="">{{ $label  }} (%)</label>
    <input
        type="text"
        class="form-control w-100 input-percentage"
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

