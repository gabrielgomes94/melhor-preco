<tr>
    <td colspan="1" class="text-wrap">
        {{ $item['issuedAt'] ?? '' }}
    </td>

    <td colspan="2" class="text-wrap">
        {{ $item['supplierName'] ?? '' }}
    </td>

    <td colspan="2">
        <x-app.costs.product-costs.details.table.detailed-costs :itemCosts="$item['costs'] ?? ''" />
    </td>

    <td colspan="1">
        {{ $item['quantity'] ?? '' }}
    </td>

    <td colspan="1">
        {{ $item['unitCost'] ?? '' }}
    </td>
</tr>
