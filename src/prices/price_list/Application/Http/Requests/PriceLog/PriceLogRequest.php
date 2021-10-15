<?php

namespace Src\Prices\PriceList\Application\Http\Requests\PriceLog;

//use App\Http\Requests\Contracts\HasOptions;
//use Src\Products\Infrastructure\Repositories\Options\Options;
//use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Foundation\Http\FormRequest;

class PriceLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

//    public function getOptions(): \Src\Prices\Application\Http\Requests\PriceLog\Options
//    {
//        $data = [
//            'page' => $this->input('page') ?? 1,
//            'sku' => $this->input('sku') ?? null,
//        ];
//
//        return new \Src\Prices\Application\Http\Requests\PriceLog\Options($data);
//    }
}
