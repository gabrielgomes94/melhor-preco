<form
    method="get"
    action="{{ $action }}"
    enctype="multipart/form-data"
    id="{{ $formId ?? '' }}"
>
    @csrf

    {{ $slot }}
</form>
