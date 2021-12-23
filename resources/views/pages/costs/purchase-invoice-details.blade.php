<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <x-slot name="header">
        Notas Fiscal de Entrada - {{ $data['contactName'] }}
    </x-slot>

    <div class="container">
        <div class="row">
            <x-template.alert-messages.alert-messages />
        </div>

        <div class="row">
            <div class="d-inline-flex justify-content-end m-1">
                <div class="mx-1">
{{--                    <x-app.costs.sync.button />--}}
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <x-app.costs.purchase-invoice.details-card :data="$data" />
{{--                <x-app.costs.purchase-invoices.table :data="$data" />--}}
            </div>
        </div>
    </div>
</x-layout>
