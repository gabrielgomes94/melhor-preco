<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <h2>Vendas</h2>
    </x-slot>

    <x-slot name="body">
        <x-app.sales.reports.product.details.content :data="$data" />
    </x-slot>
</x-bootstrap.card.basic-card>
