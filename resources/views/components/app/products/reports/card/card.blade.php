<x-bootstrap.card.basic-card>
    <x-slot name="header">
        <div class="h-100 d-inline-flex justify-content-between my-2 w-100">
            <div>
                <h3>{{ $header }}</h3>
            </div>

            <div>
                <a href="{{ route('products.reports.informations') }}"
                   class="link-primary my-2 px-2">
                    Limpar filtros
                </a>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Filtrar
                </button>
            </div>
        </div>
    </x-slot>

    <x-slot name="body">
        <x-app.products.reports.informations.table :data="$data" />

        <div class="mt-4">
            <x-bootstrap.paginator.paginator-links :paginator="$paginator" />
        </div>
    </x-slot>

</x-bootstrap.card.basic-card>
