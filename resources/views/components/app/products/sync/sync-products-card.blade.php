<div class="d-flex flex-column h-100 justify-content-between">
    <h3 class="text-center">Sincronizar produtos por API</h3>

    <div class="d-flex justify-content-center">
        <form method="post" action="{{ route('products.doSync') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="submit"  class="btn btn-primary d-block m-2" value="Sincronizar" />
        </form>
    </div>
</div>
