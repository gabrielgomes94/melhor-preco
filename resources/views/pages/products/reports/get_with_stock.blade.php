<body class="antialiased">
    <x-layout>
        <div class="row my-4">
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
                    <div class="my-2">
                        <x-bootstrap.card.basic-card>
                            <x-slot name="header">
                                <h3>Informações Gerais</h3>
                            </x-slot>

                            <x-slot name="body">
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
                            </x-slot>
                        </x-bootstrap.card.basic-card>
                    </div>
                @endif

                <div class="row my-4">
                    <div class="col-6">
                        <x-app.sales.reports.product.details.card :data="$sales"/>
                    </div>

                    <div class="col-6">
                        <x-app.sales.reports.last-sales.card :data="$sales"/>
                    </div>
                </div>


                <div class="col-12 my-4">
                    <x-app.costs.product-costs.details.card :data="$costs" :product="$product">
                        <x-slot name="header">
                            <h2>Custos</h2>
                        </x-slot>
                    </x-app.costs.product-costs.details.card>
                </div>
            </div>
        </div>
    </x-layout>
</body>
