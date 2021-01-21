
    <!-- Sidebar -->
    <nav id="sidebar">
        <header class="header header-menu">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2>Barrigudinha</h2>
            </div>
        </header>
        <ul class="list-unstyled components">
            <li>
                <a href={{ route('product.upload_images')  }}>Upload de Imagens</a>
            </li>
            <li>
                <a href={{ route('product.qr_codes') }}>Geração de QR Codes</a>
            </li>
        </ul>
        <ul class="list-unstyled components">
            <li>
                <a href={{ route('logout')  }}>Logout</a>
            </li>
        </ul>
    </nav>
