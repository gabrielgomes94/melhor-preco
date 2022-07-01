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
            @foreach ($marketplace['commissions'] as $commission)
                {{ $commission }} <br>
            @endforeach
        </td>

        <td colspan="1">
            {{ $marketplace['status'] }}
        </td>

        <td colspan="1">
            <a href="{{ route('marketplaces.setCommission', $marketplace['slug']) }}"
               class="link-info"
            >
                Configurar comissões
            </a>

            <br>

            <a href="{{ route('marketplaces.edit', $marketplace['slug']) }}"
               class="link-info"
            >
                Editar
            </a>

            <br>
        </td>
    </tr>
@endforeach
</tbody>
