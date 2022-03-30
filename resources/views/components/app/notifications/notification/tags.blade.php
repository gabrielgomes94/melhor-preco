@foreach ($tags as $tag)
    <x-bootstrap.badge.badge>
        {{ $tag }}
    </x-bootstrap.badge.badge>
@endforeach
