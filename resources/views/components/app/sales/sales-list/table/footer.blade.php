<tr>
    <td colspan="2">
        <x-app.sales.sales-list.table.footer.period
            :beginDate="$total['beginDate']"
            :endDate="$total['endDate']"
        />
    </td>

    <td colspan="2">
        <x-app.sales.sales-list.table.footer.sales-count
            :salesCount="$total['salesCount']"
            :productsCount="$total['productsCount']"
        />
    </td>

    <td colspan="3">
        <x-app.sales.sales-list.table.footer.stores-count
            :stores="$total['storesCount']"
        />
    </td>

    <td colspan="3">
        <x-app.sales.sales-list.table.footer.revenue
            :value="$total['value']"
            :profit="$total['profit']"
        />
    </td>
</tr>
