@foreach ($data as $invoice)
    <tr>
        <td>
             <x-bootstrap.links.link :route="route('costs.showPurchaseInvoices', $invoice['uuid'])">
                {{ $invoice['seriesNumber'] ?? '' }}
            </x-bootstrap.links.link>
        </td>

        <td>
            {{ $invoice['issuedAt'] }}
        </td>

        <td colspan="6">
            {{ $invoice['contactName'] }}
        </td>

        <td>
            {{ $invoice['value'] }}
        </td>

        <td>
            {{ $invoice['status'] }}
        </td>
    </tr>
@endforeach
