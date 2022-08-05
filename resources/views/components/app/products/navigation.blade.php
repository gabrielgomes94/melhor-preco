<nav class="w-100">
    <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
        <a class="nav-item nav-link {{ ($activeNavProducts ?? null) ? 'active' : '' }}"
           id="nav-home-tab"
           role="tab" aria-controls="nav-home" aria-selected="true"
           href="{{ route('products.reports.informations') }}"
        >
            Produtos
        </a>

        <div class="mx-1"></div>

        <a class="nav-item nav-link {{ ($activeNavUploadImages ?? null) ? 'active' : '' }}"
           id="nav-profile-tab"
           role="tab" aria-controls="nav-profile" aria-selected="false"
           href="{{ route('product.images.upload_form') }}"
        >
            Upload de Imagens
        </a>

        <div class="mx-1"></div>

        <a class="nav-item nav-link {{ ($activeNavReports ?? null) ? 'active' : '' }}"
           id="nav-contact-tab"
           href="{{ route('products.reports.informations') }}"
           role="tab" aria-controls="nav-contact" aria-selected="false"
        >
            Relatórios
        </a>
    </div>
</nav>
