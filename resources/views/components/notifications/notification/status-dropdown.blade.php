<a class="nav-link text-dark dropdown-toggle p-2"
   href="#"
   role="button"
   data-bs-toggle="dropdown"
   data-bs-display="static"
   aria-expanded="false"
>
    <x-layout.icons.mini-menu />
</a>

<div class="dropdown-menu dropdown-menu-end my-4 py-1">
    <div class="list-group list-group-flush">
        <x-template.forms.put
            action="{{ route('notifications.updateReadedStatus', $notification->identifier()) }}"
        >
            <input type="hidden" name="readed" value="true">

            <button class="btn dropdown-item" type="submit">
                Marcar como lido
            </button>
        </x-template.forms.put>

        <x-template.forms.put
            action="{{ route('notifications.updateSolvedStatus', $notification->identifier()) }}"
        >
            <input type="hidden" name="solved" value="true">

            <button class="btn dropdown-item" type="submit">
                Marcar como resolvido
            </button>
        </x-template.forms.put>
    </div>
</div>
