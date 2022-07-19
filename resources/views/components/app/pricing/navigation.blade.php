<nav class="w-100">
    <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
        <a class="nav-item nav-link {{ ($activeNavPrices ?? null) ? 'active' : '' }}"
           id="nav-home-tab"
           role="tab" aria-controls="nav-home" aria-selected="true"
           href="{{ route('pricing.priceList.byStore') }}"
        >
            Preços
        </a>

        <div class="mx-1"></div>

        <a class="nav-item nav-link {{ ($activeNavCosts ?? null) ? 'active' : '' }}"
           id="nav-profile-tab"
           role="tab" aria-controls="nav-profile" aria-selected="false"
           href="{{ route('costs.product.list') }}"
        >
            Custos dos produtos
        </a>

        <div class="mx-1"></div>

        <a class="nav-item nav-link {{ ($activeNavPurchaseInvoices ?? null) ? 'active' : '' }}"
           id="nav-contact-tab"
           href="{{ route('costs.listPurchaseInvoices') }}"
           role="tab" aria-controls="nav-contact" aria-selected="false"
        >
            Notas fiscais de entrada
        </a>
    </div>
</nav>
