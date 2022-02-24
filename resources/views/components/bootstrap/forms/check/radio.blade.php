<div class="form-check form-check-inline">
    <input class="form-check-input"
           type="radio"
           id="{{ $id }}"
           value="{{ $value }}"
           name="{{ $name }}"

           @if ($active ?? false)
               checked
           @endif
    >
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
</div>
