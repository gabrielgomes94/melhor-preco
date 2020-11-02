<body class="antialiased">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload de Imagens') }}
            </h2>
        </x-slot>

            <div class="container">
                <div class="row mt-4">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <h1>Upload de imagens</h1>
                            @isset($errorMsg)
                                <p class="text-danger">{{$errorMsg}}</p>
                            @endif

                        <form class="m-2" method="post" action="/file-upload" enctype="multipart/form-data">
                            @csrf
                            <p id="resultq"></p>
                            <div class="form-group ">
                                <label for="codigo">Código SKU</label>
                                <input type="text" class="form-control input-sku" id="name" placeholder="Código SKU" name="codigo">
                            </div>

                            <div class="form-group">
                                <label for="descricao">Nome</label>
                                <input type="text" class="form-control input-name" id="name" placeholder="Nome" name="descricao" readonly>
                            </div>

                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <input type="text" class="form-control input-brand" id="name" placeholder="Marca" name="marca" readonly>
                            </div>

                            <div class="form-group">
                                <label for="marca">Descrição principal</label>
                                <textarea class="form-control input-main-description" id="name" placeholder="Descrição principal do produto" name="descricaoCurta" rows="20"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="imagens">Escolha as imagens</label>
                                <input id="image" class="input-file" type="file" name="imagens[]" multiple>
                            </div>

                            <div class="preview-image" class="d-inline">

                            </div>
                            <button type="submit" class="btn btn-dark d-block w-75 mx-auto">Enviar</button>
                        </form>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
    </x-app-layout>
</body>

