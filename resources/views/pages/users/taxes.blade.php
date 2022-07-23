<x-layout>
    <x-app.users.navigation selectedNav="taxes" />

    <div class="row full-height">
        <div class="col-12">
            <x-bootstrap.alert-messages.alert-messages />

            <div class="mt-2">
                <x-app.users.taxes.card :taxRate="$taxRate"/>
            </div>
        </div>
    </div>
</x-layout>
