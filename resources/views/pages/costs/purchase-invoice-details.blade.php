<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <x-slot name="header">
        Nota Fiscal - {{ $data['contactName'] }}
    </x-slot>

    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <x-app.costs.purchase-invoice.details-card :data="$data" />
            {{--                <x-app.costs.purchase-invoices.table :data="$data" />--}}
        </div>
    </div>
</x-layout>
