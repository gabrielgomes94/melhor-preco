<label class="my-1 me-2" for="marketplaces">Marketplace</label>
<select
    class="form-select"
    name="category"
    id="marketplaces"
    aria-label="Marketplaces"
    onchange="location.href=this.value"
>

    @foreach ($marketplaces ?? [] as $marketplace)
        <option
            value="{{ route('pricing.products.calculate', [$marketplace['slug'], $productId]) }}"
            @if ($marketplace['selected'] == true)
                selected
            @endif
        >
            {{ $marketplace['name'] }}
        </option>
    @endforeach
</select>
