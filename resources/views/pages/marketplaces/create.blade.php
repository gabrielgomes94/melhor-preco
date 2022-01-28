<x-layout>
    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <h2>Cadastrar Marketplace</h2>
            </x-slot>

            <x-slot name="body">
                <x-app.stores.create-form.form />
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
