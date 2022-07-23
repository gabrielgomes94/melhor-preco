<a class="nav-item nav-link {{ ($selected ?? false) ? 'active' : '' }}"
   role="tab"
   aria-controls="nav-home" aria-selected="true"
   id="{{ $id }}"
   href="{{ $route }}"
>
    {{ $label }}
</a>
