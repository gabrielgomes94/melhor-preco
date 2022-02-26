<div class="d-inline-flex">
    {{ $previousLabel ?? '' }}

    <div class="mx-1"></div>

    <div class="form-check form-switch">
        <input class="form-check-input"
               type="checkbox"
               id="{{ $id }}"
               name="{{ $name }}"

               @if ($isDisabled ?? false) disabled @endif

               @if ($active ?? false) checked @endif
        >
    </div>

    {{ $nextLabel ?? '' }}
</div>

