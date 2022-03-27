<?php

namespace Src\Promotions\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use Src\Promotions\Domain\Models\Promotion;
use Src\Promotions\Domain\Repositories\Repository;
use Src\Promotions\Infrastructure\Laravel\Exports\PromotionSpredsheet;

class ExportSpreadsheetController
{
    public function __construct(
        private Excel $excel,
        private Repository $repository,
    )
    {}

    public function __invoke(string $promotionUuid)
    {
        $promotion = $this->repository->get($promotionUuid);
        $filename = $this->getFilename($promotion);

        return $this->excel->download(
            new PromotionSpredsheet($promotion),
            $filename
        );
    }

    private function getFilename(Promotion $promotion): string
    {
        $beginDate = $promotion->getBeginDate()->format('Y-m-d');
        $name = Str::slug($promotion->getName());

        return $beginDate . $name . '.xlsx';
    }
}
