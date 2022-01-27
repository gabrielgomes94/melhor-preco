<x-template.card.card>
    <x-template.card.card-body>
        <x-app.pricing.prices.price.card-header :post="$price"/>

        <x-app.pricing.prices.price.forms.default :productId="$productId" :price="$price"/>
    </x-template.card.card-body>
</x-template.card.card>
