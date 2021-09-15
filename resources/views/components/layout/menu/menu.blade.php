<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        {{--
            x Criar component de item de menu
                x - Adicionar opção de badge no menu-item
                x - Adicionar componentes de ícones
                    x layout/icons
            x Criar component de item de menu expandível e deixá-lo aberto ou então Criar componente de submenu
                - Adicionar as entradas para
            x Aumentar largura do menu

            - Ajustar links de cada página
            x- Melhorar o componente collapsable: remover interação para abrir e fechar o menu

        --}}

        <ul class="nav flex-column pt-3 pt-md-0">
            <x-layout.menu.menu-section name="Gestão de Produtos" icon="product-box">
                <x-layout.menu.menu-item route="{{ route('product.images.upload_form') }}" name="Upload de Imagens" icon="upload" />

                <x-layout.menu.menu-item route="{{ route('products.stock_tags.index') }}" name="Etiquetas de Estoque" icon="qr-code"/>

                <x-layout.menu.menu-item route="{{ route('products.reports.overDimension') }}" name="Relatórios" icon="docs"/>

                <x-layout.menu.menu-item route="{{ route('products.sync') }}" name="Sincronização" icon="sync"/>
            </x-layout.menu.menu-section>

            <x-layout.menu.menu-section name="Calculadora de Preços" icon="calculator">
                <x-layout.menu.menu-item route="{{ route('pricing.priceList.index') }}" name="Preços" icon="price"/>

                <x-layout.menu.menu-item route="{{ route('products.costs.edit') }}" name="Custos" icon="costs" />
            </x-layout.menu.menu-section>

            <x-layout.menu.menu-item route="{{ route('sales.list') }}" name="Gestão de Vendas" badge="beta" icon="currency" />
            <x-layout.menu.menu-item route="{{ route('home') }}" name="Configurações" badge="em breve" icon="settings" />
        </ul>
    </div>
</nav>
