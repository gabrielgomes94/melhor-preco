<div id="price-accordion-collapse-{{ $price->id }}"
     class="accordion-collapse collapse show"
     aria-labelledby="price-accordion-{{ $price->id }}"
     data-bs-parent="#accordion">

    <div class="accordion-body">
        <x-pricing.prices.calculator.calculator :pricingId="$pricingId" :productId="$productId" :price="$price"/>
    </div>
</div>
