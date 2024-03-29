<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Barrigudinha</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href={{ route('products.images.upload_form')  }}>Upload de Imagens</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('pricing.priceList.byStore', $store->slug()) }}>Precificação</a>
            </li>
            <li class="nav-item dropdown">
                <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="productDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                >
                    Produtos
                </a>
                <div class="dropdown-menu" aria-labelledby="productDropdown">
                    <a class="dropdown-item" href={{ route('products.costs.edit') }}>Atualizar Custos</a>
                </div>
            </li>
        </ul>

        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
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
