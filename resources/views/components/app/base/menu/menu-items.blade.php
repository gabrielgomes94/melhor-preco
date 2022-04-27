<x-app.base.menu.menu-item
    route="{{ route('home') }}"
    name="Dashboard"
    icon="dashboard"
/>

<x-app.base.menu.menu-item
    route="{{ route('product.images.upload_form') }}"
    name="Upload de Imagens"
    icon="upload"
/>

<x-app.base.menu.menu-item
    route="{{ route('products.reports.informations') }}"
    name="Produtos"
    icon="qr-code"
/>

<x-app.base.menu.menu-item
    route="{{ route('pricing.priceList.byStore', 'magalu') }}"
    name="Calculadora de Preços"
    icon="calculator
                    "/>

<x-app.base.menu.menu-item
    route="{{ route('sales.list') }}"
    name="Vendas"
    icon="currency"
/>

<x-app.base.menu.menu-item
    route="{{ route('home') }}"
    name="Configurações"
    icon="settings"
/>

<x-app.base.menu.logout />
