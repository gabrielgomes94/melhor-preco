<div class="form-group">
    <h2>Preços</h2>

    @foreach($prices as $price)
        <x-pricing.prices.card :price="$price" :productId="$productId"/>
    @endforeach
</div>
