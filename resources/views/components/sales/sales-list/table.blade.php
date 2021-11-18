<table class="table">
    <thead>
        <x-sales.sales-list.table.header />
    </thead>
    <tbody>
        <x-sales.sales-list.table.body :saleOrders="$saleOrders" />
        <x-sales.sales-list.table.paginator :paginator="$paginator" />
        <x-sales.sales-list.table.footer :total="$total" />
    </tbody>
</table>
