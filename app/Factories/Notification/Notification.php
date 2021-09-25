<?php

namespace App\Factories\Notification;

use App\Models\Notification as NotificationModel;
use Barrigudinha\Notification\Notification as NotificationObject;

class Notification
{
    public static function buildFromModel(NotificationModel $model): NotificationObject
    {
        return NotificationObject::fromArray([
            'id' => $model->id,
            'title' => $model->title,
            'content' => $model->content,
            'tags' => $model->tags,
            'type' => $model->type,
            'isSolved' => $model->is_solved,
            'isReaded' => $model->is_readed,
            'createdAt' => $model->created_at,
        ]);
    }
}
