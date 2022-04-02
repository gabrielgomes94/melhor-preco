<body class="antialiased">
    <x-layout>
        <div class="row my-4">
            <div class="col-sm-12">
                <div class="error-container">
                    <div id="error-box" class="">
                        <p id="error-box-message" class="text-danger"></p>
                    </div>
                </div>

                <x-bootstrap.links.link :route="$redirectLink">
                    Voltar
                </x-bootstrap.links.link>

                @isset($product)
                    <div class="my-2">
                        <x-bootstrap.card.basic-card>
                            <x-slot name="header">
                                <h3>Informações Gerais</h3>
                            </x-slot>

                            <x-slot name="body">
                                <div class="row">
                                    <div class="col-6">
                                        <x-app.products.reports.basic-info.table :product="$product" />
                                    </div>

                                    <div class="col-6">
                                        <x-app.products.reports.basic-info.images :product="$product"/>
                                    </div>
                                </div>
                            </x-slot>
                        </x-bootstrap.card.basic-card>
                    </div>
                @endif

                <div class="row my-4">
                    <div class="col-12 my-4">
                        <x-bootstrap.card.basic-card>
                            <x-slot name="header">
                                <h3>Preços</h3>
                            </x-slot>

                            <x-slot name="body">
                                <x-app.products.reports.prices.table :data="$prices" />
                            </x-slot>
                        </x-bootstrap.card.basic-card>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-6">
                        <x-app.sales.reports.product.details.card :data="$sales"/>
                    </div>

                    <div class="col-6">
                        <x-app.sales.reports.last-sales.card :data="$sales"/>
                    </div>
                </div>

                <div class="col-12 my-4">
                    <x-app.costs.product-costs.details.card.card
                        :costs="$costs"
                        :product="$product"
                    >
                        <x-slot name="header">
                            <h2>Custos</h2>
                        </x-slot>
                    </x-app.costs.product-costs.details.card.card>
                </div>
            </div>
        </div>
    </x-layout>
</body>
