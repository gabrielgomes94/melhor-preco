<x-template.card.card>
    <x-app.pricing.prices.price.card-header :price="$price" />

    <div class="row">
        <div class="col">
            <x-app.pricing.prices.price.forms.default :productId="$productId" :price="$price" />
        </div>

        <div class="col">
            <x-app.pricing.prices.price.forms.magalu-discount :productId="$productId" :price="$price" />
        </div>
    </div>
</x-template.card.card>
