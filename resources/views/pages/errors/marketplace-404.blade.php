<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between my-4">
                <x-app.errors.marketplace-404-card :identifier="$identifier" />
            </div>
        </div>
    </div>
</x-layout>
