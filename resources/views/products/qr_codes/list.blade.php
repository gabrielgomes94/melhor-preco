<body class="antialiased">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produto') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-inline-flex flex-wrap mt-4">
                    @foreach ($products as $product)
                        <div class="border-qr-code">
                            <div class="m-4">
                                <p>{{ $product['sku'] }}</p>
                                {{ $product['qrCode'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
