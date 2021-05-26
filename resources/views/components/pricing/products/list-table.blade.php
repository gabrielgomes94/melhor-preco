<div>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">SKU</th>
            <th scope="col">Produto</th>
            @foreach($stores as $store)
                <th scope="col">{{ $store }}</th>
            @endforeach
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th scope="row">{{ $product->sku }}</th>
                <td> {{ $product->name ?? 'Berço Luck Cor: Rosa'}}</td>
                @foreach($product->prices as $price)
                    <td>
                        <div class="selling-price">
                            {{ $price->value() }}
                        </div>
                        <div>
                            <div class="profit-margin">
                                {{ $price->profitMargin() }}
                            </div>
                            <div class="profit-value {{ $price->color() }}">
                                {{ $price->profit() }}
                            </div>
                        </div>
                    </td>
                @endforeach
                <td>
                    <div class="d-inline-flex justify-content-end">
                        <x-utils.navigation-button
                            :route="route('pricing.products.show', [
                            'pricing_id' => $pricingId,
                            'product_id' => $product->id
                        ])"
                            label="Detalhar"
                        />

                        <x-utils.navigation-button
                            :route="route('pricing.create')"
                            customStyleClass="btn-danger"
                            label="Remover"
                        />
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

