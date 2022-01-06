<div class="px-4 pt-4">
    <form action="{{ route('products.stock_tags.generate') }}" method="post">
        @csrf

        <table class="table">
            <thead>
            <tr>
                <th scope="col">SKU</th>
                <th scope="col">Nome</th>
                <th scope="col">Quantidade</th>
            </tr>
            </thead>

            <tbody id="input-table-body"></tbody>
        </table>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary d-block mx-auto m-2 w-25 py-2" id="button-add-product">
                Gerar QR Codes
            </button>
        </div>
    </form>
</div>
