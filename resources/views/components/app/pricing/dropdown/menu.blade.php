<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle"
            type="button"
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="currentColor"
        >
            <path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
        </svg>

    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li>
            <a class="dropdown-item" href="{{ route('pricing.priceList.byStore') }}">Calculadora de Preços</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('promotions.index') }}">Promoções</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('costs.product.list') }}">Custos dos Produtos</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('costs.listPurchaseInvoices') }}">Notas Fiscais de Entrada</a>
        </li>
    </ul>
</div>
