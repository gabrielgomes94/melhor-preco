<div>

    <!-- Be present above all else. - Naval Ravikant -->
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
                <th scope="row">{{ $product['sku'] }}</th>
                <td> {{ $product['name'] ?? 'Berço Luck Cor: Rosa'}}</td>
                @foreach($stores as $store)
                    <td>
                        <div class="selling-price">
                            R$ {{ $product['prices'][0]['value'] }}
                        </div>
                        <div>
                            <div class="profit-margin">
                                {{ $product['prices'][0]['profit_margin'] }} %
                            </div>
                            <div class="profit-value">
                                R$ {{ $product['prices'][0]['profit'] }}
                            </div>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

