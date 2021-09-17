<form
    method="get"
    action="{{ $action }}"
    id="{{ $formId ?? '' }}"
>
    {{ $slot }}
</form>
