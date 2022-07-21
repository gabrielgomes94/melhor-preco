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
                    </x-bootstrap.card.basic.card-body>
                </x-bootstrap.card.basic.card>
            </div>
        </div>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
