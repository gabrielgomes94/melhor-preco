<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle"
            type="button"
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false"
    >
        Menu
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
