<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row my-4">
        <div class="col-12">
            <h2>
                {{ $data['product']['sku'] }} - {{ $data['product']['name'] }}
            </h2>

            <div class="my-2">
                <x-app.costs.product-costs.card :data="$data"/>
            </div>
        </div>
    </div>
</x-layout>
