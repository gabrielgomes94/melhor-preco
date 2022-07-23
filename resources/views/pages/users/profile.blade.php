<x-layout>
    <x-app.users.navigation selectedNav="profile" />

    <div class="row full-height">
        <div class="col-12">
            <div class="my-4">
                <x-bootstrap.alert-messages.alert-messages />
            </div>

            <div class="my-4">
                <x-app.users.profile.card
                    :name="$name"
                    :fiscalId="$fiscalId"
                    :phone="$phone"
                />
            </div>

            <div class="my-4">
                <x-app.users.update-password.card />
            </div>
        </div>
    </div>
</x-layout>
