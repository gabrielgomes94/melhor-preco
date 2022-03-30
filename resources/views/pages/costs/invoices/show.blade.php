<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row m-4">
        <div class="col-12">
            <x-app.costs.purchase-invoice.details-card :data="$data" />
        </div>
    </div>
</x-layout>
