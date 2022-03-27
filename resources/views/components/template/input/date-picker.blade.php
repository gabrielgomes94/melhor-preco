<div>
    <label for="{{ $id }}">{{ $label ?? '' }}</label>

    <div class="input-group">
        <span class="input-group-text">
            <x-app.base.icons.calendar />
        </span>

        <input data-datepicker=""
               class="form-control"
               id="{{ $id }}"
               form="{{ $formId }}"
               name="{{ $attribute }}"
               type="text"
               placeholder="dd/mm/aaaaa"
               required
        >
    </div>
</div>
