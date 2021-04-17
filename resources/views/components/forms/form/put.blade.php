<form
    method="post"
    action="{{ $action }}"
    enctype="multipart/form-data"
>
    @method('PUT')
    @csrf

    {{ $slot }}

</form>
