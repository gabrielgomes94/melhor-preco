<body class="antialiased">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Produto') }}
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

                    <div class="content-container">
                        @isset($product)
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
                        @endif
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </x-app-layout>
</body>
