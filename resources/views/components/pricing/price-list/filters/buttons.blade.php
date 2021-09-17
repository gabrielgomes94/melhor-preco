<div class="h-100 d-flex align-content-end my-2">
    <div>
        <a href="{{ route('pricing.priceList.byStore', $store->slug()) }}"
           class="link-primary my-2">
            Limpar filtros
        </a>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            Filtrar
        </button>
    </div>
</div>
