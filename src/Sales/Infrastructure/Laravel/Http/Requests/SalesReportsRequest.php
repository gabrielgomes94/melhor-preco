<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Src\Sales\Domain\DataTransfer\SalesFilter;

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

    public function transform(): SalesFilter
    {
        $beginDate = $this->input('beginDate') ?? null;
        $endDate = $this->input('endDate') ?? null;

        return new SalesFilter(
            userId: auth()->user()->getAuthIdentifier(),
            beginDate: $beginDate
                ? Carbon::createFromFormat(SalesFilter::DATE_FORMAT, $beginDate)
                : null,
            endDate: $endDate
                ? Carbon::createFromFormat(SalesFilter::DATE_FORMAT, $endDate)
                : null,
            page: (int) $this->input('page') ?? 1,
        );
    }
}
