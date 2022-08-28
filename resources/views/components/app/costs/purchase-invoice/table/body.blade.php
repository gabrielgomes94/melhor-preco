@foreach ($items as $model)
    <tr>
        <td colspan="3">
            @empty($model['productSku'])
                {{ $model['name'] }}
            @else
                <x-bootstrap.links.link
                    :route="route('products.reports.show', $model['productSku'])"
                >
                    {{ $model['name'] }}
                </x-bootstrap.links.link>
            @endempty
        </td>

        <td>
            {{ $model['productSku'] }}
        </td>

        <td>
            {{ $model['purchasePrice'] }}
        </td>

        <td>
            Frete: {{ $model['costs']['freight'] }} <br>
            Impostos: {{ $model['costs']['taxes'] }} <br>
            Seguro: {{ $model['costs']['insurance'] }} <br>
        </td>

        <td>
            {{ $model['unitCost'] }}
        </td>

        <td>
            {{ $model['quantity'] }}
        </td>

        <td>
            {{ $model['totalValue'] }}
        </td>
    </tr>
@endforeach
