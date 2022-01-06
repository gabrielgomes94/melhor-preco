<div class="m-4">
    <table class="table w-100">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Lojas</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>

        @foreach($priceLists as $priceList)
            <tr>
                <td>{{ $priceList['name'] }}</td>
                <td>
                    @foreach ($priceList['stores'] as $store)
                        <div class="text-wrap">
                            {{ $store }}
                        </div>
                    @endforeach
                </td>
                <td>
                    <x-template.navigation.navigation-button
                        :route="route('pricing.priceList.custom.show', $priceList['id'])"
                        label="Visualizar"
                    />
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
