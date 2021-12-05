<div>
    <label for="{{ $id }}">{{ $label ?? '' }}</label>

    <div class="input-group">
        <span class="input-group-text">
            <x-layout.icons.calendar />
        </span>

        <input data-datepicker=""
               class="form-control"
               id="{{ $id }}"
               form="{{ $formId }}"
               type="text"
               name="{{ $inputName }}"
               placeholder="dd/mm/aaaaa"
        >
    </div>
</div>
