<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <x-app.pricing.dropdown.menu />
            </div>

            <x-app.costs.purchase-invoice.details-card :data="$data" />
        </div>
    </div>
</x-layout>
