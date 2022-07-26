<tbody>
@foreach ($freightTable as $freightTableRow)
    <tr>
        <td colspan="1">
            {{ $freightTableRow['initialCubicWeight'] }} - {{ $freightTableRow['endCubicWeight'] }} kg
        </td>

        <td colspan="1">
            {{ $freightTableRow['value'] }}
        </td>
    </tr>
@endforeach
</tbody>
