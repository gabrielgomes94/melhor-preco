<x-layout>
    <x-slot name="navbar">
        <x-app-costs.navbar />
    </x-slot>

    <x-slot name="header">
        Notas Fiscais de Entrada
    </x-slot>

    <div class="container">
        <div class="row">
            <x-template.alert-messages.alert-messages />
        </div>

        <div class="row mt-4">
            <div class="col-12">
{{--                <x-app.costs.purchase-invoices.table :data="$data" />--}}
            </div>
        </div>
    </div>
</x-layout>
