<div class="accordion-item">
    <h2 class="accordion-header" id="price-accordion-{{ $price->id }}">
        <button class="accordion-button" type="button"
                data-bs-toggle="collapse" data-bs-target="#price-accordion-collapse-{{ $price->id }}"
                aria-expanded="true" aria-controls="price-accordion-collapse-{{ $price->id }}">
            <div class="d-flex justify-content-between w-100">
                {{ $price->store }}
                <div>
                    Preço: R$ {{ $price->value }}<br>
                    Lucro: R$ {{ $price->profit }}<br>
                    {{ $price->margin }} %
                </div>
            </div>
        </button>
    </h2>
    <div id="price-accordion-collapse-{{ $price->id }}" class="accordion-collapse collapse"
         aria-labelledby="price-accordion-{{ $price->id }}"
         data-bs-parent="#accordion">

        <div class="accordion-body">
            <x-pricing.products.prices.calculator-form :pricingId="$pricingId" :productId="$productId" :price="$price"/>
        </div>
    </div>
</div>
