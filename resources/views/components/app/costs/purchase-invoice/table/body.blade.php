@foreach ($items as $model)
    <tr>
        <td colspan="4">
            {{ $model['name'] }}
        </td>

        <td>
            <x-bootstrap.input.text
                attribute="products[{{ $model['purchaseItemUuid'] }}]"
                visibleComponentId="{{ 'inputSku-' . $model['purchaseItemUuid'] ?? '' }}"
                :value="$model['productSku']"
            />
        </td>

        <td>
            R$ {{ $model['purchasePrice'] }}
        </td>

        <td>
            Frete: R$ {{ $model['additionalCosts']['freightValue'] ?? 0.0 }} <br>
            Impostos: R$ {{ $model['additionalCosts']['taxesValue'] ?? 0.0 }} <br>
            Seguro: R$ {{ $model['additionalCosts']['insuranceValue'] ?? 0.0 }} <br>
        </td>

        <td>
            R$ {{ $model['unitValue'] }}
        </td>

        <td>
            {{ $model['quantity'] }}
        </td>

        <td>
            R$ {{ $model['totalValue'] }}
        </td>
    </tr>
@endforeach
