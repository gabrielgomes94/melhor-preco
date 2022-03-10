<x-bootstrap.card.basic-card>
    @isset($header)
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endisset

    <x-slot name="body">
        <x-app.costs.product-costs.list.table.table :data="$data" />
    </x-slot>
</x-bootstrap.card.basic-card>
