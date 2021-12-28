@foreach ($data as $invoice)
    <tr>
        <td>
             <x-template.links.link :route="route('costs.showPurchaseInvoices', $invoice['uuid'])">
                {{ $invoice['seriesNumber'] ?? '' }}
            </x-template.links.link>
        </td>

        <td>
            {{ $invoice['issuedAt'] }}
        </td>

        <td>
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
