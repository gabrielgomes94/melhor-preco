<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <x-app.promotions.export.button
            label="Gerar planilha de promoção"
            :promotion="$promotion"
        />
    </x-slot>

    <x-slot name="body">
        <x-app.promotions.products-list.table :products="$promotion['products']" />
    </x-slot>
</x-bootstrap.card.basic-card>
