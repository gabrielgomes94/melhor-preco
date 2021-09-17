<div class="form-group">
    @foreach($prices as $price)
        <x-pricing.prices.card :price="$price" :productId="$productId"/>
    @endforeach
</div>
