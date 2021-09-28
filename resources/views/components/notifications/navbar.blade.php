<nav class="navbar navbar-expand mb-3 border-bottom border-gray-400 w-100">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item px-2">
                <a class="nav-link"
                   href="{{ route('notifications.list') }}">Inbox</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link"
                   href="{{ route('notifications.list', ['tag' => 'aviso']) }}">Avisos</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link"
                   href="{{ route('notifications.list', ['tag' => 'relatorios']) }}">Relatórios</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link"
                   href="{{ route('notifications.list', ['tag' => 'info']) }}">Informações</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link"
                   href="{{ route('notifications.list', ['filter' => 'solved']) }}">Resolvido</a>
            </li>
        </ul>
    </div>
</nav>
