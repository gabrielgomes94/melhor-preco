<x-layout>
    <div class="container">
        <div class="row mb-4">
            <div class="my-4">
                <h1>Calculadora de Preços</h1>
            </div>

            <x-bootstrap.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>

            <div class="mb-4">
                <x-bootstrap.links.link :route="route('products.reports.show', $productInfo['id'])">
                    <h3>{{ $productInfo['header'] }}</h3>
                </x-bootstrap.links.link>

                <x-bootstrap.alert-messages.alert-messages />
            </div>

            <div class="row mb-4">
                <div class="col-4">
                    <x-app.pricing.prices.calculator.card
                        :calculatorForm="$calculatorForm"
                    />

                    <div class="my-4">
                        <x-app.pricing.prices.marketplace.card
                            :marketplacesList="$marketplacesList"
                            :productId="$productInfo['id']"
                        >
                        </x-app.pricing.prices.marketplace.card>
                    </div>

                    <x-app.pricing.prices.update-costs.card
                        :costsForm="$costsForm"
                        :productId="$productInfo['id']"
                    />
                </div>

                <div class="col-8">
                    <x-app.pricing.prices.price.card
                        :price="$calculatedPrice['formatted']"
                        :priceRaw="$calculatedPrice['raw']"
                        :productId="$productInfo['id']"
                        :productInfo="$productInfo"
                    />
                </div>
            </div>
        </div>
    </div>
</x-layout>
