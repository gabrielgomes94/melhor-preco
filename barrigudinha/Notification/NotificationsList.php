<?php

namespace Barrigudinha\Notification;

use Barrigudinha\Utils\BaseIterator;

class NotificationsList extends BaseIterator
{

    protected function build(array $data): array
    {
        foreach ($data as $notification) {
            if ($notification instanceof Notification) {
                $notifications[] = $notification;

                continue;
            }
        }

        return $notifications ?? [];
    }

    public function toArray(): array
    {
        return array_map(function (Notification $notification) {
            return $notification->toArray();

        }, $this->objects);
    }
}
