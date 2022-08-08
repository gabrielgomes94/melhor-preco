@foreach ($items as $model)
    <tr>
        <td colspan="3">
            {{ $model['name'] }}
        </td>

        <td>
            <x-bootstrap.forms.input.text
                attribute="products[{{ $model['purchaseItemUuid'] }}]"
                visibleComponentId="{{ 'inputSku-' . $model['purchaseItemUuid'] ?? '' }}"
                :value="$model['productSku']"
            />
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
