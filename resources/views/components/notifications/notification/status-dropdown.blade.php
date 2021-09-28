<a class="nav-link text-dark dropdown-toggle p-2"
   href="#"
   role="button"
   data-bs-toggle="dropdown"
   data-bs-display="static"
   aria-expanded="false"
>
    <x-layout.icons.mini-menu />
</a>

<div class="dropdown-menu my-4">
    <div class="list-group list-group-flush">
        <x-template.forms.put
            action="{{ route('notifications.updateReadedStatus', $notification->toArray()['id']) }}"
        >
            <input type="hidden" name="readed" value="true">

            <button class="btn" type="submit">
                Marcar como lido
            </button>
        </x-template.forms.put>

        <x-template.forms.put
            action="{{ route('notifications.updateSolvedStatus', $notification->toArray()['id']) }}"
        >
            <input type="hidden" name="solved" value="true">

            <button class="btn" type="submit">
                Marcar como resolvido
            </button>
        </x-template.forms.put>
    </div>
</div>
