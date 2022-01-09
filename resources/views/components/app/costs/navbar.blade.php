<nav class="navbar navbar-expand mt-2 mb-3 border-bottom border-gray-400 w-100 pb-0">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item px-2 py-1" id="nav-product-costs">
                <a class="nav-link"
                   href={{ route('costs.product.list')  }}
                >
                    Custos de produtos
                </a>
            </li>

            <li class="nav-item px-2 py-1" id="nav-invoice-costs">
                <a class="nav-link"
                   href={{ route('costs.listPurchaseInvoices')  }}
                >
                    Notas fiscais de entrada
                </a>
            </li>
        </ul>
    </div>
</nav>
