<x-bootstrap.card.basic-card>
    <x-slot name="header">
        Integração com ERP
    </x-slot>

    <x-slot name="body">
        <x-app.users.integrations.form :erpToken="$erpToken" />
    </x-slot>
</x-bootstrap.card.basic-card>
