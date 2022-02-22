<div class="form-check form-switch">
    <input class="form-check-input"
           type="checkbox"
           id="{{ $id }}"
           name="{{ $name }}"

           @if ($isDisabled)
                disabled
           @endif
    >
    <label class="form-check-label" for="{{ $id }}">{{ $label ?? '' }}</label>
</div>
