<div class="form-group">
    <h2>Preços</h2>

    <x-pricing.products.prices.accordion>
        @foreach($prices as $price)
            <x-pricing.products.prices.accordion-item :price="$price" :pricingId="$pricingId" :productId="$productId"></x-pricing.products.prices.accordion-item>
        @endforeach
    </x-pricing.products.prices.accordion>
</div>
