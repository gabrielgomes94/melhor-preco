<nav class="
    navbar navbar-expand-md navbar-transparent navbar-dark navbar-theme-primary
    w-100
    d-none d-lg-flex"
>
    <div class="d-flex w-100">
        <div class="navbar-collapse collapse w-100 d-flex justify-content-between"
             id="navbar-default-primary"
        >
            <div class="d-flex flew-row">
                <ul class="navbar-nav navbar-nav-hover">
                    <x-app.base.menu.items.menu-item
                        route="{{ route('pricing.priceList.byStore') }}"
                        name="Calculadora de Preços"
                        icon="calculator
                    "/>
                </ul>

                <ul class="navbar-nav navbar-nav-hover">
                    <x-app.base.menu.items.menu-item
                        route="{{ route('products.reports.informations') }}"
                        name="Produtos"
                        icon="product-box"
                    />
                </ul>

                <ul class="navbar-nav navbar-nav-hover">
                    <x-app.base.menu.items.menu-item
                        route="{{ route('sales.list') }}"
                        name="Vendas"
                        icon="currency"
                    />
                </ul>

                <ul class="navbar-nav navbar-nav-hover">
                    <x-app.base.menu.items.menu-item
                        route="{{ route('users.settings.integrations') }}"
                        name="Configurações"
                        icon="settings"
                    />
                </ul>
            </div>

            <div>
                <ul class="navbar-nav navbar-nav-hover">
                    <x-app.base.menu.items.logout />
                </ul>
            </div>
        </div>
    </div>
</nav>
