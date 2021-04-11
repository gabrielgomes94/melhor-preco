<div class="m-4">
    <table class="table w-100">
        <thead>
        <tr>
            <th scope="col" class="w-10">Código</th>
            <th scope="col" class="w-10">Nome</th>
            <th scope="col" class="w-50">Produtos</th>
            <th scope="col" class="w-30">Lojas</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach($campaigns as $campaign)
            <tr>
                <th scope="row">{{ $campaign['id'] }}</th>
                <td>{{ $campaign['name'] }}</td>
                <td class="w-50">
                    @foreach ($campaign['products'] as $product)
                        <div class="text-wrap">
                            {{ $product }}
                        </div>
                    @endforeach
                </td>
                <td>
                    @foreach ($campaign['stores'] as $store)
                        <div class="text-wrap">
                            {{ $store }}
                        </div>
                    @endforeach
                </td>
                <td>
                    <x-utils.navigation-button
                        :route="route('pricing.show', $campaign['id'])"
                        label="Visualizar"
                    />
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
