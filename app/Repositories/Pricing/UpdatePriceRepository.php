<?php

namespace App\Repositories\Pricing;

use App\Models\Price;

class UpdatePriceRepository
{
    public function update(string $id, array $data)
    {
        $model = Price::find($id);

        if (!$model) {
            // TODO: tratar isso
            dd('nao existe');
        }

        $model->profit = $data['profit'];
        $model->value = $data['value'];
        $model->save();
    }
}
