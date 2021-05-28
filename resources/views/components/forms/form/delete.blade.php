<form
    method="post"
    action="{{ $action }}"
    enctype="multipart/form-data"
>
    @method('DELETE')
    @csrf

    {{ $slot }}
</form>
