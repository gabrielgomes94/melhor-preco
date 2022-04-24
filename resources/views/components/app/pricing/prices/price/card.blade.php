<x-bootstrap.card.basic.card class="h-100">
    <x-bootstrap.card.basic.card-body>
        <x-app.pricing.prices.price.card-header :productInfo="$productInfo"/>

        <x-app.pricing.prices.calculated-price.table
            :productId="$productId"
            :price="$price"
            :priceRaw="$priceRaw"
        />

        <x-app.pricing.prices.price.forms.default :productId="$productId" :price="$price"/>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
