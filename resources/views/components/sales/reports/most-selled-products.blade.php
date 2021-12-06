<table class="table">
    <thead>
        <x-sales.reports.table.header />
    </thead>

    <tbody>
        <x-sales.reports.table.body :products="$products"/>
{{--    <x-sales.sales-list.table.body :saleOrders="$saleOrders" />--}}
{{--    <x-sales.sales-list.table.paginator :paginator="$paginator" />--}}
{{--    <x-sales.sales-list.table.footer :total="$total" />--}}
    </tbody>
</table>
