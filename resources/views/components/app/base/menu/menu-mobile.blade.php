<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <div></div>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-none bg-gray-800 text-white collapse">
    <div class="sidebar-inner px-4 pt-3">
        <ul class="nav d-flex flex-column pt-3 pt-md-0">
            <div class="p-2 bd-highlight">
                <x-app.base.menu.menu-item-mobile
                    route="{{ route('home') }}"
                    name="Dashboard"
                    icon="dashboard"
                />

                <x-app.base.menu.menu-item-mobile
                    route="{{ route('product.images.upload_form') }}"
                    name="Upload de Imagens"
                    icon="upload"
                />

                <x-app.base.menu.menu-item-mobile
                    route="{{ route('products.reports.informations') }}"
                    name="Produtos"
                    icon="qr-code"
                />

                <x-app.base.menu.menu-item-mobile
                    route="{{ route('pricing.priceList.byStore', 'magalu') }}"
                    name="Calculadora de Preços"
                    icon="calculator"
                />

                <x-app.base.menu.menu-item-mobile
                    route="{{ route('sales.list') }}"
                    name="Vendas"
                    icon="currency"
                />

                <x-app.base.menu.menu-item-mobile
                    route="{{ route('home') }}"
                    name="Configurações"
                    icon="settings"
                />

                <x-app.base.menu.logout-mobile />
            </div>
        </ul>
    </div>
</nav>
