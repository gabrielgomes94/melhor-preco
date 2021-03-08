<div class="m-4">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Nome</th>
            <th scope="col">Produtos</th>
            <th scope="col">Lojas</th>
        </tr>
        </thead>
        <tbody>

        @foreach($campaigns as $campaign)
            <tr>
                <th scope="row">1</th>
                <td>{{ $campaign->name }}</td>
                <td>{{ $campaign->skuList() }}</td>
                <td> asddasdasaad </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
