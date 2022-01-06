<div class="py-2">
    <x-template.forms.post action="{{ route('costs.sync') }}">
        <button class="btn btn-primary" type="submit">
            Sincronizar

            <x-app.base.icons.icon icon="sync" />
        </button>
    </x-template.forms.post>
</div>
