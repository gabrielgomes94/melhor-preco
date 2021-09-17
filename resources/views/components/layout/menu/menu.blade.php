<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <ul class="nav d-flex flex-column pt-3 pt-md-0">
            <div class="p-2 bd-highlight">
                <x-layout.menu.menu-section name="Gestão de Produtos" icon="product-box">
                    <x-layout.menu.menu-item route="{{ route('product.images.upload_form') }}" name="Upload de Imagens" icon="upload" />

                    <x-layout.menu.menu-item route="{{ route('products.stock_tags.index') }}" name="Etiquetas de Estoque" icon="qr-code"/>

                    <x-layout.menu.menu-item route="{{ route('products.reports.overDimension') }}" name="Relatórios" icon="docs"/>

                    <x-layout.menu.menu-item route="{{ route('products.sync') }}" name="Sincronização" icon="sync"/>
                </x-layout.menu.menu-section>

                <x-layout.menu.menu-section name="Calculadora de Preços" icon="calculator">
                    <x-layout.menu.menu-item route="{{ route('pricing.priceList.byStore', 'magalu') }}" name="Preços" icon="price"/>

                    <x-layout.menu.menu-item route="{{ route('products.costs.edit') }}" name="Custos" icon="costs" />
                </x-layout.menu.menu-section>

                <x-layout.menu.menu-item route="{{ route('sales.list') }}" name="Gestão de Vendas" badge="beta" icon="currency" />
                <x-layout.menu.menu-item route="{{ route('home') }}" name="Configurações" badge="em breve" icon="settings" />
                <x-utils.logout />
            </div>
        </ul>
    </div>
</nav>