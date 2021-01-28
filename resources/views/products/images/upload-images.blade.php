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
                        <div class="error-container">
                            <div id="error-box" class="">
                                <p id="error-box-message" class="text-danger"></p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{$error}}</p>
                                    @endforeach
                                </div>
                            @endif

                            @isset($data['message'])
                                <div class="alert alert-primary">
                                    <p class="text-primary">Upload feito com sucesso. </p>
                                </div>
                            @endisset
                        </div>


                        <div class="form-group">
                            <form method="post" action="{{ route('product.images.upload') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group ">
                                    <label for="codigo">Código SKU</label>
                                    <input type="text" class="form-control input-sku" id="name" placeholder="Código SKU" name="sku">
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Nome</label>
                                    <input type="text" class="form-control input-name" id="name" placeholder="Nome" name="description" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input type="text" class="form-control input-brand" id="name" placeholder="Marca" name="brand">
                                </div>

                                <div class="form-group">
                                    <input name="file[]" type="file" class="input-file" multiple />
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
