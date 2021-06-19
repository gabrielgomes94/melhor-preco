<x-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sincronização de dados de produtos') }}
        </h1>
    </x-slot>

    <x-layout.grid.container.single-row-2-8-2>
        <h2>Sincronização</h2>
        <form method="post" action="{{ route('products.doSync') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="submit"  class="btn btn-dark d-block w-50 m-2" value="Sincronizar" />
        </form>
    </x-layout.grid.container.single-row-2-8-2>


    <x-layout.grid.container.single-row-2-8-2>
        <h2>Atualização de ICMS por Planilha</h2>
        <div class="form-group">
            <form method="post" action="{{ route('products.doUpdateICMS') }}" enctype="multipart/form-data">
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
