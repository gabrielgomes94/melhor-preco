<x-layout>
    <x-slot name="navbar">
        <x-app.costs.navbar />
    </x-slot>

    <x-slot name="header">
        Atualizar custos dos produtos por planilha
    </x-slot>

    <div class="container">
        <div class="row">
            <x-template.alert-messages.alert-messages />
        </div>

        <div class="row mt-4">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="form-group">
                    <form method="post" action="{{ route('products.doUpdateICMS') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="file">Escolha o arquivo</label><br>
                            <input name="file" type="file" class="input-file" />
                            <div class="preview-image d-flex" ></div>
                        </div>

                        <input type="submit"  class="btn btn-dark d-block w-50 m-2" value="Enviar" />
                    </form>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</x-layout>
