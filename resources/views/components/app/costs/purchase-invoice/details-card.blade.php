<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="d-inline-flex justify-content-between align-items-center m-1">
            <h2>Nota fiscal</h2>
        </div>

        <x-app.costs.purchase-invoice.invoice-info :data="$data" />

        <div class="m-1 w-100">
            <x-bootstrap.buttons.submit label="Voltar"/>
        </div>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
