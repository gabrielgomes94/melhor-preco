<table class="table">
    <thead>
        <x-app.sales.sales-list.table.header />
    </thead>
    <tbody>
        <x-app.sales.sales-list.table.body :saleOrders="$saleOrders" />
        <x-app.sales.sales-list.table.paginator :paginator="$paginator" />
        <x-app.sales.sales-list.table.footer :total="$total" />
    </tbody>
</table>
