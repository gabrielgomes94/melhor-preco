<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <x-slot name="header">
        Notas Fiscais de Entrada
    </x-slot>

    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="d-inline-flex justify-content-end m-1">
            <div class="mx-1">
                <x-app.costs.sync.button />
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <x-template.card.card>
                <x-app.costs.purchase-invoices.table :data="$data" />
            </x-template.card.card>
        </div>
    </div>
</x-layout>
