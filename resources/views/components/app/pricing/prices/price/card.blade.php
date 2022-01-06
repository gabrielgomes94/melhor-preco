<x-template.card.card>
    <x-app.pricing.prices.price.card-header :post="$post" :product="$product" :price="$price"/>

    <x-app.pricing.prices.price.forms.default :productId="$productId" :post="$post" :price="$price"/>
</x-template.card.card>
