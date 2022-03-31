<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <h3>{{ $header }}</h3>
    </x-slot>

    <x-slot name="body">
        {{ $slot }}
    </x-slot>

</x-bootstrap.card.basic-card>
