<div class="my-2 mb-4">
    <x-template.card.card>
        <div class="row d-flex d-sm-flex d-md-flex d-lg-flex d-xl-none">
            <div class="col-12 mb-4 bg-blue-100">
                <x-notifications.inbox.main-message.card :notification="$mainNotification" />
            </div>
            <div class="col-12">
                <div class="message-wrapper border-0 bg-white shadow">
                    @foreach ($notifications as $notification)
                        <x-notifications.inbox.message-list.card :notification="$notification" />
                    @endforeach
                </div>

                <div class="my-4">
                    <x-utils.paginator-links :paginator="$paginator"/>
                </div>
            </div>
        </div>

        <div class="row d-none d-sm-none d-md-none d-lg-none d-xl-flex">
            <div class="col-xl-6">
                <div class="message-wrapper border-0 bg-white shadow">
                    <x-notifications.inbox.message-list.container :notifications="$notifications" />
                </div>

                <div class="mt-4">
                    <x-utils.paginator-links :paginator="$paginator"/>
                </div>
            </div>

            <div class="col-xl-6">
                <x-notifications.inbox.main-message.card :notification="$mainNotification" />
            </div>
        </div>
    </x-template.card.card>
</div>
