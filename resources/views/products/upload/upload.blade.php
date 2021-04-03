<x-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atualização de Produtos por Planilha') }}
        </h1>
    </x-slot>

    <x-layout.grid.container.single-row-2-8-2>
        <div class="form-group">
            <form method="post" action="{{ route('products.doUpload') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="file">Escolha o arquivo</label><br>
                    <input name="file[]" type="file" class="input-file" multiple />
                    <div class="preview-image d-flex" ></div>
                </div>

                <input type="submit"  class="btn btn-dark d-block w-50 m-2" value="Enviar" />
            </form>
        </div>
    </x-layout.grid.container.single-row-2-8-2>
</x-layout>
