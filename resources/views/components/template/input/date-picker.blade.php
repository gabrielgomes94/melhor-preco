<div>
    <label for="{{ $id }}">{{ $label ?? '' }}</label>
    <div class="input-group">
    <span class="input-group-text">
        <x-layout.icons.calendar />
    </span>

        <input data-datepicker="" class="form-control" id="{{ $id }}" type="text" placeholder="dd/mm/yyyy" required>
    </div>

</div>
