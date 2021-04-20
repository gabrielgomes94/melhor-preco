<div class="form-group">
    <h4>Preços</h4>

    <x-pricing.products.prices.accordion>
        @foreach($prices as $price)
            <x-pricing.products.prices.accordion-item :price="$price" :pricingId="$pricingId" :productId="$productId"></x-pricing.products.prices.accordion-item>
        @endforeach
    </x-pricing.products.prices.accordion>
</div>
