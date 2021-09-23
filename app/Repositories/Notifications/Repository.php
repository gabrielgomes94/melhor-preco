<?php

namespace App\Repositories\Notifications;

use Barrigudinha\Notification\Notification;
use Barrigudinha\Notification\NotificationsList;
use Carbon\Carbon;

class Repository
{
    public function get(): Notification
    {
        $data = $this->getData()[0];

        return Notification::fromArray($data);
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
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => true,
            ],
            [
                'id' => '417 ',
                'title' => 'Produto 1231 está com prejuízo no Mercado Livre!',
                'content' => 'Preço: R$ 100 | Lucro R$ 200',
                'tags' => ['price', 'loss'],
                'type' => 'alert',
                'createdAt' => Carbon::now(),
                'isSolved' => false,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Existem 120 produtos com menos de 3 imagens nas postagens!',
                'content' => '',
                'tags' => ['products'],
                'type' => 'report',
                'createdAt' => Carbon::now(),
                'isSolved' => false,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
            [
                'id' => '123',
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => '',
                'tags' => ['sync', 'products'],
                'type' => 'info',
                'createdAt' => Carbon::now(),
                'isSolved' => true,
                'wasReaded' => false,
            ],
        ];
    }
}
