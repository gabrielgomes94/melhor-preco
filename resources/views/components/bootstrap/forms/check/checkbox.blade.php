<div class="form-check form-check-inline">
    <input class="form-check-input"
           type="checkbox"
           id="{{ $id ?? '' }}"
           value="{{ $value ?? '' }}"
           name="{{ $name ?? '' }}"

        @if ($active ?? false)
           checked
        @endif

        @if ($disabled ?? false)
           disabled
        @endif
    >
    <label class="form-check-label" for="{{ $id ?? '' }}">{{ $label }}</label>
</div>
