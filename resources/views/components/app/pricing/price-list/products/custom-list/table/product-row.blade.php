<tr>
    <th scope="row">{{ $product->sku() }}</th>
    <td> {{ $product->name() }}</td>
    @foreach($stores as $store)
        <td>
            <div class="selling-price">
                {{ $product->price($store->slug()) }}
            </div>
            <div>
                <div class="profit-margin">
                    {{ $product->margin($store->slug()) }}
                </div>
                <div class="profit-value">
                    {{ $product->profit($store->slug()) }}
                </div>
            </div>
        </td>
    @endforeach
    <td>
        <div class="d-inline-flex justify-content-end">
            <x-template.navigation.navigation-button
                :route="route('pricing.priceList.custom.product.show', [
                            'price_list_id' => $priceList->id(),
                            'product_id' => $product->sku()
                        ])"
                label="Detalhar"
            />
        </div>
    </td>
</tr>

