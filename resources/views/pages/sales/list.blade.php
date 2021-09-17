<x-layout>
    <x-slot name="header">
        Vendas
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>
    </div>

    <div class="row">
        <div class="d-flex justify-content-end">
            <x-template.forms.get :action="route('sales.export')">
                <div class="d-flex align-items-end py-2">
                    <x-template.buttons.submit label="Exportar planilha" />
                </div>
            </x-template.forms.get>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-12">
            <x-template.card.card>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Pedido</th>
                        <th scope="col">Data</th>
                        <th scope="col">Produtos</th>
                        <th scope="col">Loja</th>
                        <th scope="col">Status</th>
                        <th scope="col">Valor total</th>
                        <th scope="col">Lucro total</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($saleOrders as $saleOrder)
                        <tr>
                            <td>{{ $saleOrder['saleOrderCode'] }}</td>
                            <td>{{ $saleOrder['selledAt'] }}</td>
                            <td class="text-break"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ implode(';', $saleOrder['products']) }}"
                            >
                                @foreach ($saleOrder['products'] as $product)
                                    {{ $product }} <br>
                                @endforeach
                            </td>
                            <td>{{ $saleOrder['store'] }}</td>
                            <td>{{ $saleOrder['status'] }}</td>
                            <td>
                                R$ {{ $saleOrder['value'] }}
                            </td>
                            <td>
                                R$ {{ $saleOrder['profit'] }}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-break"></td>
                        <td>
                            R$ {{ $total['value'] }}
                        </td>
                        <td>
                            R$ {{ $total['profit'] }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </x-template.card.card>
        </div>
    </div>
</x-layout>
