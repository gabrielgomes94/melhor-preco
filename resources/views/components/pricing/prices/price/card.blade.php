<x-template.card.card>
    <x-pricing.prices.price.card-header :post="$post" :product="$product" :price="$price"/>

    <x-pricing.prices.price.forms.default :productId="$productId" :post="$post" :price="$price"/>
</x-template.card.card>
