<form
    method="post"
    action="{{ $action }}"
    enctype="multipart/form-data"
    id="{{ $formId ?? '' }}"
>
    @method('PUT')
    @csrf

    {{ $slot }}
</form>
