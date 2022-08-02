<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="row">
            <div class="col-4">
                <x-bootstrap.card.basic.card>
                    <x-bootstrap.card.basic.card-body>
                        <h4>Atualizar custos</h4>

                        <x-app.pricing.prices.update-costs.form
                            :costs="$costsForm"
                            :productId="$productId"
                        />
                    </x-bootstrap.card.basic.card-body>
                </x-bootstrap.card.basic.card>

            </div>

            <div class="col-8">
                <x-bootstrap.card.basic.card>
                    <x-bootstrap.card.basic.card-body>
                        <h3>Última nota fiscal de entrada</h3>

                        <x-app.costs.product-costs.details.table.table
                            :costs="$costs"
                        />
                    </x-bootstrap.card.basic.card-body>
                </x-bootstrap.card.basic.card>
            </div>
        </div>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
