<x-layout>
    <x-slot name="navbar">
        <x-app.users.navbar />
    </x-slot>

    <div class="row full-height">
        <div class="col-12">
            <x-bootstrap.alert-messages.alert-messages />

            <div class="mt-2">
                <x-app.users.integrations.card :erpToken="$erpToken" />
            </div>
        </div>
    </div>
</x-layout>
