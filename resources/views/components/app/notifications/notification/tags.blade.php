@foreach ($tags as $tag)
    <x-template.badge.badge>
        {{ $tag }}
    </x-template.badge.badge>
@endforeach
