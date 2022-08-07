<nav id="sidebarMenu" class="sidebar d-lg-none bg-gray-800 text-white collapse">
    <div class="sidebar-inner px-4 pt-3">
        <ul class="nav d-flex flex-column pt-3 pt-md-0">
            <div class="p-2 bd-highlight">
                <x-app.base.menu.items.menu-item
                    route="{{ route('pricing.priceList.byStore', 'magalu') }}"
                    name="Calculadora de Preços"
                    icon="calculator
                    "/>

                <x-app.base.menu.items.menu-item
                    route="{{ route('products.reports.informations') }}"
                    name="Produtos"
                    icon="product-box"
                />

                <x-app.base.menu.items.menu-item
                    route="{{ route('sales.list') }}"
                    name="Vendas"
                    icon="currency"
                />

                <x-app.base.menu.items.menu-item
                    route="{{ route('users.settings.integrations') }}"
                    name="Configurações"
                    icon="settings"
                />

                <x-app.base.menu.items.logout />
            </div>
        </ul>
    </div>
</nav>
