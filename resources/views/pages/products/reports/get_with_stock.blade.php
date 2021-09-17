<body class="antialiased">
    <x-layout>
        <x-slot name="header">
            Produto
        </x-slot>

        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="error-container">
                    <div id="error-box" class="">
                        <p id="error-box-message" class="text-danger"></p>
                    </div>
                </div>

                @isset($product)
                    <x-template.card.card>
                        <div class="content-container">
                            <ul>
                                <li>
                                    <b>SKU:</b> {{ $product['sku'] }}
                                </li>
                                <li>
                                    <b>Nome:</b> {{ $product['name'] }}
                                </li>
                                <li>
                                    <b>Estoque atual:</b> {{ $product['stock'] }}
                                </li>
                            </ul>
                        </div>
                    </x-template.card.card>
                @endif
            </div>
        </div>
    </x-layout>
</body>
