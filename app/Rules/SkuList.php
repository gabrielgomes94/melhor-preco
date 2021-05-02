<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SkuList implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value= preg_replace('/\s+/', ' ', $value);
        $skus = explode(' ', $value);

        foreach($skus as $sku) {
            if (!is_numeric($sku)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'SKU inválido. Digite SKUs válidos, separados por espaços';
    }
}
