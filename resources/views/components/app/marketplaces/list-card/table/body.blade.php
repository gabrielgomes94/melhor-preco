<tbody>
@foreach ($marketplaces as $marketplace)
    <tr>
        <td colspan="1">
            {{ $marketplace['name'] }}
        </td>
        <td colspan="1">
            {{ $marketplace['erpId'] }}
        </td>
        <td colspan="1">
            {{ $marketplace['commissions'] }}
        </td>
        <td colspan="1">
            <a href="#" class="link-primary">Configurar comissões</a>
        </td>
    </tr>
@endforeach
</tbody>
