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
                            @isset($errorMsg)
                                <p class="text-danger">{{$errorMsg}}</p>
                            @endif

                        <div class="form-group">
                            <form id="dropzone" method="post" action="/file-upload" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group ">
                                    <label for="codigo">Código SKU</label>
                                    <input type="text" class="form-control input-sku" id="name" placeholder="Código SKU" name="codigo" form="dropzone">
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Nome</label>
                                    <input type="text" class="form-control input-name" id="name" placeholder="Nome" name="descricao" readonly form="dropzone">
                                </div>

                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input type="text" class="form-control input-brand" id="name" placeholder="Marca" name="marca" form="dropzone">
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
    </x-app-layout>

<script type="text/javascript">
    let input = document.querySelector('.input-sku');
    let inputName = document.querySelector('.input-name');
    let inputBrand = document.querySelector('.input-brand');

    // document.addEventListener("DOMContentLoaded", function() {
    //     // access Dropzone here
    //     Dropzone.options.dropzone = {
    //         paramName: "file",
    //         maxFilesize: 256,
    //         addRemoveLinks: true,
    //         dictDefaultMessage: "Clique aqui ou arraste as imagens",
    //         dictRemoveFile: 'excluir',
    //         uploadMultiple: true,
    //         autoProcessQueue: false,
    //         parallelUploads: 256,
    //         init: function(){
    //             var submitButton = document.querySelector("#submit-all");
    //             myDropzone = this;
    //
    //             submitButton.addEventListener('click', function(){
    //                 myDropzone.processQueue();
    //             });
    //         },
    //         success: function(file) {
    //             window.location.href = "/sucesso";
    //         },
    //         error: function(file) {
    //         }
    //     };
    // });



    let inputDescription = document.querySelector('.input-main-description');

    input.addEventListener('change', function () {
        const base = window.location.href
        const api_url = base + "api/product/" + this.value;

        // Defining async function
        async function getapi(url) {
            const response = await fetch(url);

            var data = await response.json();

            if (response) {
                inputName.value = data['descricao']
                inputBrand.value = data['marca']
                // inputDescription.textContent = data['descricaoCurta']
            }
        }

        getapi(api_url);
    });

    let inputFile = document.querySelector('.input-file');
    inputFile.addEventListener('change', function () {
        var mime_types = [ 'image/jpeg', 'image/png' ];
        var files = Array.from(this.files)

        files.forEach(function(file, index) {
            if(mime_types.indexOf(file.type) == -1) {
                alert('Error : Incorrect file type');
                return;
            }

            var previewURL = URL.createObjectURL(file);
            var div = document.querySelector('.preview-image');
            var img = document.createElement("img");

            img.setAttribute('src', previewURL);
            img.setAttribute('width', 180);
            img.style.margin = '12px'
            div.append(img);
        })
    });




</script>
</body>

