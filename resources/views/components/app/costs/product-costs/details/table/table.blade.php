<table class="table w-100">
    <thead>
        <x-app.costs.product-costs.details.table.header />
    </thead>

    <tbody>
        @foreach($data as $item)
            <x-app.costs.product-costs.details.table.item-row :item="$item" />
        @endforeach
    </tbody>
</table>
