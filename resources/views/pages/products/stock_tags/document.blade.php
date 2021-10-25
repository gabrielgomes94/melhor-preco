<x-template.layouts.pdf>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-inline-flex flex-wrap">
                    <table width="100%" style="width:100%;" border="0" cellspacing="8">
                        @foreach ($products as $productRow)
                            <tr>
                                @foreach ($productRow as $product)
                                    <td>
                                        <div class="m-4">
                                            <div class="fs-5" style="width: 6rem;">
                                                {{ $product['sku'] }}
                                            </div>

                                            <div class="mb-1 mt-1">
                                                {!! $product['qrCode'] !!}
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-template.layouts.pdf>
