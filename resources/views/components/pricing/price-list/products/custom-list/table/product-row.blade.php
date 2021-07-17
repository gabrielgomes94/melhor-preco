<tr>
    <th scope="row">{{ $product->sku() }}</th>
    <td> {{ $product->name() }}</td>
    @foreach($stores as $store)
        <td>
            <div class="selling-price">
                {{ $product->price($store) }}
            </div>
            <div>
                <div class="profit-margin">
                    {{ $product->margin($store) }}
                </div>
                <div class="profit-value">
                    {{ $product->profit($store) }}
                </div>
            </div>
        </td>
    @endforeach
    <td>
        <div class="d-inline-flex justify-content-end">
            <x-utils.navigation-button
                :route="route('pricing.priceList.custom.product.show', [
                            'price_list_id' => $priceList->id(),
                            'product_id' => $product->sku()
                        ])"
                label="Detalhar"
            />
        </div>
    </td>
</tr>

