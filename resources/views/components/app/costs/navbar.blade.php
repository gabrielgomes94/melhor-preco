<nav class="navbar navbar-expand mb-3 border-bottom border-gray-400">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item px-2">
                <a class="nav-link"
                   href={{ route('costs.listPurchaseInvoices')  }}
                >
                    Notas fiscais de entrada
                </a>
            </li>

            <li class="nav-item px-2">
                <a class="nav-link"
                   href={{ route('costs.edit')  }}
                >
                    Atualizar custos
                </a>
            </li>

            <li class="nav-item px-2">
                <a class="nav-link"
                   href={{ route('costs.uploadSpreadsheet')  }}
                >
                    Importar planilha
                </a>
            </li>
        </ul>
    </div>
</nav>
