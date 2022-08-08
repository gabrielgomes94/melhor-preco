<x-layout>
    <x-app.pricing.navigation :activeNavPrices="true"/>

    <div class="row mb-4">
        <div class="mb-4">
            <x-bootstrap.alert-messages.alert-messages />
        </div>

        <div class="row mb-4 d-flex justify-content-between">
            <div>
                <x-bootstrap.links.link :route="route('products.reports.show', $productInfo['id'])">
                    <h3>{{ $productInfo['header'] }}</h3>
                </x-bootstrap.links.link>
            </div>

            <div>
                <x-app.pricing.products.dropdown.marketplaces
                    :marketplaces="$marketplacesList"
                    :productSku="$productInfo['id']"
                />
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-12">
                <x-app.pricing.prices.calculator.card
                    :calculatorForm="$calculatorForm"
                    :price="$calculatedPrice['formatted']"
                    :priceId="$priceId"
                    :priceRaw="$calculatedPrice['raw']"
                    :productId="$productInfo['id']"
                    :productInfo="$productInfo"
                />
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <x-app.pricing.prices.update-costs.card
                    :costsForm="$costsForm"
                    :productId="$productInfo['id']"
                    :costs="$costs"
                />
            </div>
        </div>
    </div>
</x-layout>
