@foreach ($items as $model)
    <tr>
        <td>
            {{ $model['product'] }}
        </td>

        <td>
            <x-template.input.text
                attribute="sku[]"
                visibleComponentId="{{ 'inputSku-' . $model['purchaseItemUuid'] ?? '' }}"
                :value="$model['productSku']"
            />
        </td>

        <td>
            {{ $model['purchasePrice'] }}
        </td>

        <td>
            Frete: {{ $model['additionalCosts']['freightValue'] }} <br>
            Impostos {{ $model['additionalCosts']['taxesValue'] }} <br>
            Seguro {{ $model['additionalCosts']['insuranceValue'] }} <br>
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
