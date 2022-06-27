<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Promotions;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use Src\Prices\Domain\Models\Promotion;
use Src\Prices\Domain\Repositories\PromotionsRepository;
use Src\Prices\Infrastructure\Laravel\Exports\PromotionSpredsheet;

class ExportSpreadsheetController
{
    public function __construct(
        private Excel                $excel,
        private PromotionsRepository $repository,
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
