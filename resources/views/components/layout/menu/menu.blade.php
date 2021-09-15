<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        {{--
            x Criar component de item de menu
                - Adicionar opção de badge no menu-item
                x - Adicionar componentes de ícones
                    x layout/icons
            x Criar component de item de menu expandível e deixá-lo aberto ou então Criar componente de submenu
                - Adicionar as entradas para
            Aumentar largura do menu
        --}}

        <ul class="nav flex-column pt-3 pt-md-0">
            <x-layout.menu.menu-item-collapsable route="{{ route('home') }}" name="Gestão de Produtos" icon="table">
                <x-layout.menu.menu-item route="{{ route('home') }}" name="Upload de Imagens" />

                <x-layout.menu.menu-item route="{{ route('home') }}" name="Etiquetas de Estoque" />

                <x-layout.menu.menu-item route="{{ route('home') }}" name="Sincronização de Produtos" />
            </x-layout.menu.menu-item-collapsable>

            <x-layout.menu.menu-item-collapsable route="{{ route('home') }}" name="Calculadora de Preços" icon="table">
                <x-layout.menu.menu-item route="{{ route('home') }}" name="Preços" />

                <x-layout.menu.menu-item route="{{ route('home') }}" name="Atualização de Custos" />
            </x-layout.menu.menu-item-collapsable>

            <x-layout.menu.menu-item route="{{ route('home') }}" name="Gestão de Vendas" badge="beta" />
            <x-layout.menu.menu-item route="{{ route('home') }}" name="Configurações" />
        </ul>
    </div>
</nav>
