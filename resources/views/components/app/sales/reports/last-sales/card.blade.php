<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <h2>Últimas Vendas</h2>
    </x-slot>

    <x-slot name="body">
        <x-app.sales.reports.last-sales.content :data="$data" />
    </x-slot>
</x-bootstrap.card.basic-card>
