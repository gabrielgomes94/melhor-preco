<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;

class SalesReportsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function transform(): ListSalesFilter
    {
        return new ListSalesFilter(
            [
                'beginDate' => $this->input('beginDate') ?? null,
                'endDate' => $this->input('endDate') ?? null,
                'page' => (int) $this->input('page') ?? 1,
                'url' => $this->fullUrlWithQuery($this->query()),
                'userId' => auth()->user()->getAuthIdentifier(),
            ]
        );
    }
}
