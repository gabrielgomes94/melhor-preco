<nav class="navbar navbar-expand-lg mb-3 border-bottom border-gray-400 header-navbar">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item px-2">
                <a class="nav-link {{ $selected == 'b2w' ? 'active' : '' }}"
                   href={{ route('pricing.priceList.byStore', 'b2w')  }}>B2W</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link {{ $selected == 'magalu' ? 'active' : '' }}"
                   href={{ route('pricing.priceList.byStore', 'magalu')  }}>Magalu</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link {{ $selected == 'mercado_livre' ? 'active' : '' }}"
                   href={{ route('pricing.priceList.byStore', 'mercado_livre')  }}>Mercado Livre</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link {{ $selected == 'olist' ? 'active' : '' }}"
                   href={{ route('pricing.priceList.byStore', 'olist')  }}>Olist</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link {{ $selected == 'shopee' ? 'active' : '' }}"
                   href={{ route('pricing.priceList.byStore', 'shopee')  }}>Shopee</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link {{ $selected == 'simulation' ? 'active' : '' }}"
                   href='#'  }}>Simulação (em breve)</a>
            </li>
        </ul>
    </div>
</nav>
