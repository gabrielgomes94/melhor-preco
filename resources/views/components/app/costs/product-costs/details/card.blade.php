<x-bootstrap.card.basic-card>
    @isset($header)
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endisset

    <x-slot name="body">
        <x-app.costs.product-costs.details.table.table :data="$data['items']" />
    </x-slot>
</x-bootstrap.card.basic-card>
