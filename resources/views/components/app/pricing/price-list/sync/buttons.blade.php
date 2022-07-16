<div class="h-100 d-flex align-content-end">
    <x-bootstrap.forms.form.post
        :action="route('pricing.sync', $store)"
    >
        <x-bootstrap.forms.input.submit
            label="Sincronizar"
        />
    </x-bootstrap.forms.form.post>
</div>
