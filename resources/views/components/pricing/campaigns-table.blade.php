<div class="m-4">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Nome</th>
            <th scope="col">Produtos</th>
            <th scope="col">Lojas</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach($campaigns as $campaign)
            <tr>
                <th scope="row">1</th>
                <td>{{ $campaign['name'] }}</td>
                <td>{{ $campaign['products'] }}</td>
                <td>{{ $campaign['stores'] }}</td>
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
