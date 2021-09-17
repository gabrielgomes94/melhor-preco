<nav class="navbar navbar-expand-lg mb-3 border-bottom border-gray-400">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link link-primary" href={{ route('pricing.priceList.byStore', 'b2w')  }}>B2W</a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-success " href={{ route('pricing.priceList.byStore', 'magalu')  }}>Magalu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('pricing.priceList.byStore', 'mercado_livre')  }}>Mercado Livre</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('pricing.priceList.byStore', 'olist')  }}>Olist</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('pricing.priceList.byStore', 'shopee')  }}>Shopee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='#'  }}>Simulação (em breve)</a>
            </li>
        </ul>
    </div>
</nav>
