{{--<table class="table w-100">--}}
<x-bootstrap.table.bordered-table>
    <thead>
        <x-app.costs.product-costs.list.table.header />
    </thead>

    <tbody>
        @foreach($data as $item)
            <x-app.costs.product-costs.list.table.item-row :item="$item" />
        @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
{{--</table>--}}
