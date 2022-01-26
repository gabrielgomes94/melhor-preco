<body class="antialiased">
    <x-layout>
        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="error-container">
                    <div id="error-box" class="">
                        <p id="error-box-message" class="text-danger"></p>
                    </div>
                </div>

                <x-template.links.link :route="$redirectLink">
                    Voltar
                </x-template.links.link>



                @isset($product)

                    <x-template.card.card>
                        <h3>Informações Gerais</h3>
                        <div class="content-container">
                            <ul>
                                <li>
                                    <b>SKU:</b> {{ $product['sku'] }}
                                </li>
                                <li>
                                    <b>Nome:</b> {{ $product['name'] }}
                                </li>
                                <li>
                                    <b>Estoque atual:</b> {{ $product['quantity'] }}
                                </li>
                            </ul>
                        </div>
                    </x-template.card.card>
                @endif

                <div class="col-12 mt-2">
                    <x-app.sales.reports.product.details.card :data="$sales"/>
                </div>

                <div class="col-12 mt-2">
                    <x-app.costs.product-costs.details.card :data="$costs"/>
                </div>
            </div>
        </div>
    </x-layout>
</body>
