<?php

namespace App\Http\Controllers\Front\Notifications;

use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function list()
    {
//        $data = $this->getData();

        return view('pages.notifications.inbox', $this->getData());
    }

    public function show(string $id)
    {
        return view('pages.notifications.inbox');
    }

    private function getData(): array
    {
        return [
            'notifications' => [
                [
                    'id' => '123',
                    'title' => 'Produtos sincronizados com sucesso!',
                    'isSolved' => true,
                    'tag' => 'syncronização',
                ],
                [
                    'id' => '212',
                    'title' => 'Produtos 1231 está dando prejuízo no Mercado Livre!',
                    'isSolved' => false,
                    'tag' => 'preço',
                ],
                [
                    'id' => '341',
                    'title' => 'Atualize a alíquota do Simples Nacional.',
                    'isSolved' => true,
                    'tag' => 'custos',
                ],
                [
                    'id' => '932',
                    'title' => 'Relatório de Vendas - Setembro 2021!',
                    'isSolved' => false,
                    'tag' => 'vendas',
                ],
                [
                    'id' => '341',
                    'title' => 'Verifique a nova Nota de Entrada.',
                    'isSolved' => false,
                    'tag' => 'custos',
                ],
                [
                    'id' => '341',
                    'title' => 'Verifique a nova Nota de Entrada.',
                    'isSolved' => false,
                    'tag' => 'custos',
                ],
            ],
            'mainNotification' => [
                'title' => 'Produtos sincronizados com sucesso!',
                'content' => 'Os produtos foram sincronizados com sucesso em 25/08/2022 às 00:03.',
                'tag' => 'syncronização'
            ]
        ];
    }
}
