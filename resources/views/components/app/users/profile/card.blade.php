<x-bootstrap.card.basic-card>
    <x-slot name="header">
        Informações da Conta
    </x-slot>

    <x-slot name="body">
        <x-app.users.profile.form
            :name="$name"
            :fiscalId="$fiscalId"
            :phone="$phone"
        />
    </x-slot>
</x-bootstrap.card.basic-card>
