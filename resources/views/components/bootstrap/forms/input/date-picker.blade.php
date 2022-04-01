<div>
    <label for="{{ $id }}">{{ $label ?? '' }}</label>

    <div class="input-group">
        <span class="input-group-text">
            <x-app.base.icons.calendar />
        </span>

        <input data-datepicker=""
               class="form-control"
               id="{{ $id }}"
               type="text"
               placeholder="dd/mm/aaaaa"
               name="{{ $attribute }}"
               value="{{ $value ?? '' }}"
        >
    </div>
</div>
