<x-layout>
    <div class="row full-height">
        <x-app.users.navigation selectedNav="integrations" />

        <div class="col-12">
            <x-bootstrap.alert-messages.alert-messages />

            <div class="mt-2">
                <x-app.users.integrations.card :erpToken="$erpToken" />
            </div>

            <div class="mt-2">
                <x-app.users.sync.card
                    :categories="$categories"
                    :prices="$prices"
                    :products="$products"
                    :purchaseInvoices="$purchaseInvoices"
                    :sales="$sales"
                />
            </div>
        </div>
    </div>
</x-layout>
