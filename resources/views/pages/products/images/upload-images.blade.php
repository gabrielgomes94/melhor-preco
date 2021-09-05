<body class="antialiased">
    <x-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload de Imagens') }}
            </h2>
        </x-slot>

            <div class="container">
                <div class="row mt-4">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <x-utils.alert-messages />

                        <div class="form-group">
                            <form method="post" action="{{ route('product.images.upload') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group ">
                                    <label for="sku">Código SKU</label>
                                    <input type="text" class="form-control input-sku" id="sku" placeholder="Código SKU" name="sku">
                                </div>

                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control input-name" id="name" placeholder="Nome" name="name" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input type="text" class="form-control input-brand" id="brand" placeholder="Marca" name="brand">
                                </div>

                                <div class="form-group">
                                    <label for="imagens">Imagens</label>
                                    <input name="images[]" type="file" class="input-file" id="imagens" multiple />
                                    <div class="preview-image d-flex" ></div>
                                </div>

                                <input type="submit"  class="btn btn-dark d-block w-75 mx-auto m-2" value="Enviar" />
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
    </x-layout>
</body>
