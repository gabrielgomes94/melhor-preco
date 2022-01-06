<form
    method="post"
    action="{{ $action }}"
    enctype="multipart/form-data"
    id="{{ $formId ?? '' }}"
>
    @csrf

    {{ $slot }}
</form>
