<li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
        <span class="sidebar-icon">
            <x-app.base.icons.icon icon="logout" />
        </span>

        Logout
    </a>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>
