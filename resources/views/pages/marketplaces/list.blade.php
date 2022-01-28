<x-layout>
    <div class="m-4">
        <x-bootstrap.card.basic-card>
            <x-slot name="header">
                <h2>Marketplaces Integrados</h2>
            </x-slot>

            <x-slot name="body">
                <x-bootstrap.table.bordered-table>
                    <x-app.marketplaces.list-card.table.header>
                    </x-app.marketplaces.list-card.table.header>

                    <x-app.marketplaces.list-card.table.body :marketplaces="$marketplaces">
                    </x-app.marketplaces.list-card.table.body>
                </x-bootstrap.table.bordered-table>
            </x-slot>
        </x-bootstrap.card.basic-card>
    </div>
</x-layout>
