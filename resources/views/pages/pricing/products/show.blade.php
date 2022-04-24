<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$navbar['selected']" :marketplaces="$navbar['marketplaces']"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-bootstrap.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row mb-4">
        <div class="mb-4">
            <x-bootstrap.links.link :route="route('products.reports.show', $productInfo['id'])">
                <h3>{{ $productInfo['header'] }}</h3>
            </x-bootstrap.links.link>
        </div>

        <div class="col-4">
            <div class="mb-4">
                <x-app.pricing.prices.calculator.card
                    :calculatorForm="$calculatorForm"
                />
            </div>

            <x-app.pricing.prices.update-costs.form
                :costs="$costsForm"
                :productId="$productInfo['id']"
            />
        </div>

        <div class="col-8">
            <x-app.pricing.prices.price.card
                :price="$calculatedPrice"
                :productId="$productInfo['id']"
            />
        </div>
    </div>
</x-layout>
