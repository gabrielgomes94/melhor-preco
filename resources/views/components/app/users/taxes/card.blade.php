<x-bootstrap.card.basic-card>
    <x-slot name="header">
        Impostos
    </x-slot>

    <x-slot name="body">
        <x-app.users.taxes.form :taxRate="$taxRate" />
    </x-slot>
</x-bootstrap.card.basic-card>
