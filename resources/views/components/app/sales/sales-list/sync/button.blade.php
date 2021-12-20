<div class="py-2">
    <x-forms.form.post action="{{ route('sales.sync') }}">
        <button class="btn btn-primary" type="submit">
            Sincronizar

            <x-layout.icons.icon icon="sync" />
        </button>
    </x-forms.form.post>
</div>
