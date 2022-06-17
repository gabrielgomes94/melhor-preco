<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row m-4">
        <div class="col-12">
            <x-app.costs.sync.button />

            <x-app.costs.purchase-invoices.card :data="$data" />
        </div>
    </div>
</x-layout>
