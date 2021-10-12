@foreach ($tags as $tag)
    <x-utils.badge>
        {{ $tag }}
    </x-utils.badge>
@endforeach
