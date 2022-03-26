<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <x-bootstrap.buttons.primary-link route="{{ route('promotions.doCalculate')  }}">
            Gerar planilha de promoção
        </x-bootstrap.buttons.primary-link>
    </x-slot>

    <x-slot name="body">
        <x-app.promotions.products-list.table :products="$promotion['products']" />
    </x-slot>
</x-bootstrap.card.basic-card>
