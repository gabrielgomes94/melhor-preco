<x-bootstrap.table.bordered-table>
    <thead>
        <x-app.costs.product-costs.details.table.header />
    </thead>

    <tbody>
    @foreach($costs as $product)
        @if (!empty($product))
            <x-app.costs.product-costs.details.table.item-row :item="$product" />
        @endif
    @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
