<body class="antialiased">
    <x-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('QR Codes') }}
            </h2>
        </x-slot>

        <div class="container">
            <div class="row mt-4">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="error-container">
                        <div id="error-box" class="">
                            <p id="error-box-message" class="text-danger"></p>
                        </div>
                    </div>

                    <form>
                        <div class="">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="">
                                        <label for="sku" class="form-label">Sku</label>
                                        <input type="number" class="form-control input-sku" id="sku" aria-describedby="sku">
                                    </div>
                                </div>


                                <div class="col-sm">
                                    <div class="">
                                        <label for="stock-amount" class="form-label">Quantidade</label>
                                        <input type="number" class="form-control input-stock-amount" id="stock-amount" aria-describedby="stock-amount">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <button type="button" class="btn btn-primary" id="button-add-product">Adicionar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control input-name" id="name" aria-describedby="name" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <form action="qr_codes/new" method="post">
                        @csrf
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Quantidade</th>
                            </tr>
                            </thead>
                            <tbody id="input-table-body">
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary" id="button-add-product">Submit</button>
                    </form>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </x-layout>
</body>
