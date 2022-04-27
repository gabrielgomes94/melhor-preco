<li class="nav-item">
    <a class="nav-link p-2 m-1 w-100"
       href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
        <span class="sidebar-icon">
            <x-app.base.icons.icon icon="logout" />
        </span>

        <span class="sidebar-text">Logout</span>
    </a>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>
