<?php

namespace App\Repositories\Notifications;

use Barrigudinha\Notification\Notification;
use Barrigudinha\Notification\NotificationsList;
use Carbon\Carbon;

class Repository
{
    public function get(?string $id): ?Notification
    {
        $data = $this->getData();

        foreach ($data as $notification) {
            if ($id === $notification['id']) {
                return Notification::fromArray($notification);
            }
        }

        return null;
    }

    public function list(): NotificationsList
    {
        $data = $this->getData();

        foreach ($data as $notification) {
            $notifications[] = Notification::fromArray($notification);
        }

        return new NotificationsList($notifications);
    }

    private function getData(): array
    {
        return [
            [
                'id' => '321',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => 'Os produtos foram sincronizados com o Bling com sucesso!',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => true,
            ],
            [
                'id' => '417',
                'title' => 'Produto 1231 está com prejuízo no Mercado Livre!',
                'content' => 'Preço: R$ 100 | Lucro R$ 200',
                'tags' => ['preço', 'prejuízo'],
                'type' => 'alert',
                'createdAt' => Carbon::now(),
                'isSolved' => false,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Existem 120 produtos com menos de 3 imagens nas postagens!',
                'content' => '',
                'tags' => ['produtos'],
                'type' => 'report',
                'createdAt' => Carbon::now(),
                'isSolved' => false,
                'wasReaded' => false,
            ],
            [
                'id' => '124',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '125',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '126',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '127',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '128',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '129',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '130',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sincronização', 'produtos'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
        ];
    }
}
