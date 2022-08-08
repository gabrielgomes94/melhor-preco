<x-layout>
    <x-app.pricing.navigation :activeNavPurchaseInvoices="true"/>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <x-app.costs.purchase-invoices.card :data="$data" />
        </div>
    </div>
</x-layout>
