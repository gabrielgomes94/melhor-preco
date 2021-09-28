<div class="row d-flex d-sm-flex d-md-flex d-lg-flex d-xl-none">
    <div class="col-12 mb-4">
        <x-notifications.inbox.main-message.card :notification="$mainNotification">
        </x-notifications.inbox.main-message.card>
    </div>
    <div class="col-12">
        <x-notifications.inbox.message-list.container :notifications="$paginator->items()" />
    </div>

    <div class="my-4">
        <x-utils.paginator-links :paginator="$paginator"/>
    </div>
</div>
