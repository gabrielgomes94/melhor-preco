<div class="row d-none d-sm-none d-md-none d-lg-none d-xl-flex">
    <div class="col-xl-6">
        <x-app.notifications.inbox.message-list.container :notifications="$paginator->items()" :filter="$filter" />

        <div class="mt-4">
            <x-utils.paginator-links :paginator="$paginator"/>
        </div>
    </div>

    <div class="col-xl-6">
        <x-app.notifications.inbox.main-message.card :notification="$mainNotification">
        </x-app.notifications.inbox.main-message.card>
    </div>
</div>
