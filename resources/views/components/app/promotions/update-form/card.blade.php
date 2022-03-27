<x-bootstrap.card.basic-card>
    <x-slot name="header">
        Editar promoção
    </x-slot>

    <x-slot name="body">
        <x-app.promotions.update-form.form :promotion="$promotion" />
    </x-slot>
</x-bootstrap.card.basic-card>
