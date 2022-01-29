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
            <a href="{{ route('marketplaces.setCommission', $marketplace['uuid']) }}"
               class="link-info"
            >
                Configurar comissões
            </a>
        </td>
    </tr>
@endforeach
</tbody>
