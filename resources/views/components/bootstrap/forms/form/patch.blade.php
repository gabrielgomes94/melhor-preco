<form
    method="post"
    action="{{ $action }}"
    enctype="multipart/form-data"
    id="{{ $formId ?? '' }}"
>
    @method('PATCH')
    @csrf

    {{ $slot }}
</form>
