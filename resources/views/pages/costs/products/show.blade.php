<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row my-4">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <x-app.pricing.dropdown.menu />
            </div>

            <div class="my-2">
                <x-app.costs.product-costs.details.card.card
                    :costs="$costs"
                    :product="$product"
                />
            </div>
        </div>
    </div>
</x-layout>
