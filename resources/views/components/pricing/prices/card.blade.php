<x-template.card.card>
    <div class="d-flex justify-content-end w-100">
        <h4>R$ {{ $price->value }}</h4>
    </div>

    <x-pricing.prices.calculator.calculator :productId="$productId" :price="$price"/>
</x-template.card.card>
