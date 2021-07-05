<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Produtos que Excedem Dimensões') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <table class="table w-100">
                    <thead>
                    <tr>
                        <th scope="col" class="w-10">SKU</th>
                        <th scope="col" class="w-10">Nome</th>
                        <th scope="col" class="w-10">Preço de Custo</th>
                        <th scope="col" class="w-10">Alíquota de ICMS</th>
                        <th scope="col" class="w-10">Custos Adicionais</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->sku() }}</td>
                            <td>{{ $product->name() }}</td>
                            <td>{{ $product->purchasePrice() }}</td>
                            <td>{{ $product->taxICMS() }}</td>
                            <td>{{ $product->additionalCosts() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</x-layout>
