<x-bootstrap.forms.form.get :action="route('promotions.export', $promotion['uuid'])">
    <x-bootstrap.forms.input.submit
        label="{{ $label }}"
    />
</x-bootstrap.forms.form.get>
