<x-bootstrap.table.bordered-table>
    <x-app.marketplaces.freight.table.header>
    </x-app.marketplaces.freight.table.header>

    <x-app.marketplaces.freight.table.body :freightTable="$freightTable">
    </x-app.marketplaces.freight.table.body>
</x-bootstrap.table.bordered-table>

<x-bootstrap.links.link :route="route('marketplaces.downloads.freightTable', $marketplaceSlug)">
    Download da tabela de frete
</x-bootstrap.links.link>
