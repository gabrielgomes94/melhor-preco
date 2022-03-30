<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="d-inline-flex justify-content-between align-items-center">
            <div class="mx-1">
                <h2>Notas fiscais de compra</h2>
            </div>

            <div class="mx-1">
                <x-app.costs.sync.button />
            </div>
        </div>

        <x-app.costs.purchase-invoices.table.table :data="$data" />
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
