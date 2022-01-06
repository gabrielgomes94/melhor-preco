@foreach ($items as $model)
    <tr>
        <td colspan="4">
            {{ $model['name'] }}
        </td>

        <td>
            <x-template.input.text
                attribute="products[{{ $model['purchaseItemUuid'] }}]"
                visibleComponentId="{{ 'inputSku-' . $model['purchaseItemUuid'] ?? '' }}"
                :value="$model['productSku']"
            />
        </td>

        <td>
            {{ $model['purchasePrice'] }}
        </td>

        <td>
            Frete: {{ $model['additionalCosts']['freightValue'] ?? 0.0 }} <br>
            Impostos {{ $model['additionalCosts']['taxesValue'] ?? 0.0 }} <br>
            Seguro {{ $model['additionalCosts']['insuranceValue'] ?? 0.0 }} <br>
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
