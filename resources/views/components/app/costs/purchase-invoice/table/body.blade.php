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
            Frete: {{ $model['additionalCosts']['freightValue'] }} <br>
            Impostos: {{ $model['additionalCosts']['taxesValue'] }} <br>
            Seguro: {{ $model['additionalCosts']['insuranceValue'] }} <br>
        </td>

        <td>
            {{ $model['unitValue'] }}
        </td>

        <td>
            {{ $model['quantity'] }}
        </td>

        <td>
            {{ $model['totalValue'] }}
        </td>
    </tr>
@endforeach
