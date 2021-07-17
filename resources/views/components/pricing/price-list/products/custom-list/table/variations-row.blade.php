@foreach($variations as $variation)
<tr>
    <th></th>
    <td> {{ $variation->sku() }} - {{ $variation->name() }}</td>
    @foreach($stores as $store)
        <td>
            <div class="selling-price">
                {{ $variation->price($store) }}
            </div>
            <div>
                <div class="profit-margin">
                    {{ $variation->margin($store) }}
                </div>
                <div class="profit-value">
                    {{ $variation->profit($store) }}
                </div>
            </div>
        </td>
    @endforeach
    <td>
        <div class="d-inline-flex justify-content-end">
            <x-utils.navigation-button
                :route="route('pricing.priceList.custom.product.show', [
                            'price_list_id' => $priceList->id(),
                            'product_id' => $variation->sku()
                        ])"
                label="Detalhar"
            />
        </div>
    </td>
</tr>
@endforeach

