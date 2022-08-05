<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle"
            type="button"
            id="priceListOptionsDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
    >
        <x-app.base.icons.add />
    </button>

    <ul class="dropdown-menu" aria-labelledby="priceListOptionsDropdown">
        <li>
            <a class="dropdown-item" href="#">
                Exportar
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#massCalculation">
                Calcular em massa
            </a>
        </li>

        <li>
            <x-bootstrap.forms.form.post
                :action="route('pricing.sync', $marketplaceSlug)"
            >
                <input
                    type="submit"
                    class="btn btn-link m-0"
                    value="Sincronizar"
                />

            </x-bootstrap.forms.form.post>
        </li>
    </ul>
</div>
