<body class="antialiased">
<x-layout>
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
                                <div class="fs-5" style="width: 6rem;">
                                    {{ $product['sku'] }}
                                </div>

                                <div class="mb-1 mt-1">
                                    {{ $product['qrCode'] }}
                                </div>

                                <div class="text-wrap" style="width: 6.5rem; font-size: 0.9rem;">
                                    {{ $product['name'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>
