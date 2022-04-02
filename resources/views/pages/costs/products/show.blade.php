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
                {{ $product['sku'] }} - {{ $product['name'] }}
            </h2>

            <div class="my-2">
                <x-app.costs.product-costs.details.card.card
                    :costs="$costs"
                />
            </div>
        </div>
    </div>
</x-layout>
