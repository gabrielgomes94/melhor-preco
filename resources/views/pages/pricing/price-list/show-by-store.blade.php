<x-layout>
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">SKU</th>
                    <th scope="col">Produto</th>
                    <th scope="col">{{ $store->name }}</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{ $product->sku }}</th>
                        <td> {{ $product->name }}</td>
                        <td>
                            <div>
                                Preço: {{ $product->value }} <br>
                                Lucro: {{ $product->profit }} <br>
                                Margem: {{ $product->margin }} <br>

                            </div>
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
