<x-bootstrap.navigation.nav-tabs>
    <x-bootstrap.navigation.nav-item
        id="nav-products-informations"
        label="Produtos"
        class="{{ ($activeNavProducts ?? null) ? 'active' : '' }}"
        :route="route('products.reports.informations')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-products-upload-images"
        label="Upload de Imagens"
        class="{{ ($activeNavUploadImages ?? null) ? 'active' : '' }}"
        :route="route('products.images.upload_form')"
    />
</x-bootstrap.navigation.nav-tabs>
