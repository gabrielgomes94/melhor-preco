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
                    :activeNavCosts="true"
                />
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
