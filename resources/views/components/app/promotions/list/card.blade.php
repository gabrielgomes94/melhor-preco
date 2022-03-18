<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <x-bootstrap.buttons.primary-link route="{{ route('promotions.doCalculate')  }}">
            Simular promoção
        </x-bootstrap.buttons.primary-link>
    </x-slot>

    <x-slot name="body">
        <x-app.promotions.list.table />
    </x-slot>
</x-bootstrap.card.basic-card>
