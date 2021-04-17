<div class="form-group">
    <h2>Preços</h2>

    <x-pricing.prices.accordion>
        @foreach($prices as $price)
            <x-pricing.prices.accordion-item :price="$price"></x-pricing.prices.accordion-item>
        @endforeach
    </x-pricing.prices.accordion>
</div>
