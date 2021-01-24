
    <!-- Sidebar -->
    <nav id="sidebar">
        <header class="header header-menu">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2>Barrigudinha</h2>
            </div>
        </header>
        <div class="">
            <ul class="list-unstyled components">
                <li>
                    <a href={{ route('product.images.upload_form')  }}>Upload de Imagens</a>
                </li>
                <li>
                    <a href={{ route('product.qr_codes') }}>Geração de QR Codes</a>
                </li>
            </ul>
            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        Logout
                    </a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </nav>
