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
                            <th scope="col" class="w-10">Profundidade</th>
                            <th scope="col" class="w-10">Largura</th>
                            <th scope="col" class="w-10">Altura</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overDimensionProducts as $product)
                            <tr>
                                <td>{{ $product->sku() }}</td>
                                <td>{{ $product->name() }}</td>
                                <td>{{ $product->dimensions()->depth() }}</td>
                                <td>{{ $product->dimensions()->width() }}</td>
                                <td>{{ $product->dimensions()->height() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</x-layout>
