<form
    method="post"
    action="{{ $action }}"
    enctype="multipart/form-data"
>
    @csrf

    {{ $slot }}
</form>
