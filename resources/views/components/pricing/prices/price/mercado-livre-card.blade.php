<x-template.card.card>
        <x-pricing.prices.price.card-header :price="$price" />

        <div class="row">
            <div class="col">
                <x-pricing.prices.price.forms.default :productId="$productId" :price="$price" />
            </div>

            <div class="col">
                <x-pricing.prices.price.forms.without-freight :productId="$productId" :price="$price" />
            </div>
        </div>
</x-template.card.card>