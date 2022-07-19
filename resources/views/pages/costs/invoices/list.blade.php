<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex mb-2">
                <x-app.pricing.navigation
                    :activeNavPurchaseInvoices="true"
                />
            </div>

            <x-app.costs.purchase-invoices.card :data="$data" />
        </div>
    </div>
</x-layout>
