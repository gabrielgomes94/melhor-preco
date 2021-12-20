<div class="py-2">
    <x-forms.form.post action="{{ route('sales.sync') }}">
        <button class="btn btn-primary" type="submit">
            Sincronizar

            <x-app.base.icons.icon icon="sync" />
        </button>
    </x-forms.form.post>
</div>
