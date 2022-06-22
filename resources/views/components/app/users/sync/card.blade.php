<x-bootstrap.card.basic-card>
    <x-slot name="header">
        Sincronização com ERP
    </x-slot>

    <x-slot name="body">
        <x-bootstrap.table.borderless-table>
            <thead>
                <tr>
                    <th></th>
                    <th>Quantidade</th>
                    <th>Última sincronização</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <x-app.users.sync.table.categories-row :categories="$categories" />

                <x-app.users.sync.table.products-row :products="$products" />

                <x-app.users.sync.table.purchase-invoices-row :purchaseInvoices="$purchaseInvoices" />

                <x-app.users.sync.table.prices-row :prices="$prices" />


                <x-app.users.sync.table.sales-row :sales="$sales" />
            </tbody>


        </x-bootstrap.table.borderless-table>
    </x-slot>
</x-bootstrap.card.basic-card>
