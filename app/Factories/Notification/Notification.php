<?php

namespace App\Factories\Notification;

use App\Models\Notification as NotificationModel;
use Barrigudinha\Notification\Notification as NotificationObject;
use Carbon\Carbon;

/**
 * @deprecated
 */
class Notification
{
    public static function buildFromModel(NotificationModel $model): NotificationObject
    {
        $solvedAt = $model->solved_at
            ? Carbon::createFromFormat('Y-m-d H:i:s', $model->solved_at)
            : null;

        $readAt = $model->read_at
            ? Carbon::createFromFormat('Y-m-d H:i:s', $model->read_at)
            : null;

        return NotificationObject::fromArray([
            'id' => $model->id,
            'title' => $model->title(),
            'content' => $model->content(),
            'tags' => $model->tags(),
            'solvedAt' => $solvedAt,
            'readAt' => $readAt,
            'createdAt' => $model->created_at,
        ]);
    }
}
