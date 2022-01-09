<tr>
    <td colspan="1" class="text-wrap">
        {{ $item['issuedAt'] }}
    </td>

    <td colspan="2" class="text-wrap">
        {{ $item['supplierName'] }}
    </td>

    <td colspan="2">
        <b>Preço de Compra:</b> R$ {{ $item['costs']['purchasePrice'] }} <br>
        <b>Impostos:</b> R$ {{ $item['costs']['taxes'] }} <br>
        <b>Frete:</b> R$ {{ $item['costs']['freight'] }} <br>
        <b>Seguro:</b> R$ {{ $item['costs']['insurance'] }} <br>
        <b>Alíquota ICMS:</b> {{ $item['costs']['icms'] }}%
    </td>

    <td colspan="1">
        {{ $item['quantity'] }}
    </td>

    <td colspan="1">
        R$ {{ $item['unitCost'] }}
    </td>
</tr>
