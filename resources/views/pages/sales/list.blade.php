<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendas') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nº do Pedido</th>
                            <th scope="col">Data</th>
                            <th scope="col">Loja</th>
                            <th scope="col">Status</th>
                            <th scope="col">SKUs</th>
                            <th scope="col">Valor total</th>
                            <th scope="col">Lucro total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleOrders as $saleOrder)
                        <tr>
                            <td>{{ $saleOrder['saleOrderCode'] }}</td>
                            <td>{{ $saleOrder['selledAt'] }}</td>
                            <td>{{ $saleOrder['store'] }}</td>
                            <td>{{ $saleOrder['status'] }}</td>
                            <td>{{ $saleOrder['skus'] }}</td>
                            <td>{{ $saleOrder['totalValue'] }}</td>
                            <td>{{ $saleOrder['profit'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

</x-layout>
