<?php

namespace App\Console\Commands;

use App\Services\Product\RecalculateProfit as RecalculateProfitService;
use Illuminate\Console\Command;

class RecalculateProfit extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:recalculate-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate profit from all products';

    private RecalculateProfit $recalculateProfitService;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(RecalculateProfitService $recalculateProfitService)
    {
        $recalculateProfitService->recalculateAll();

        return 0;
    }
}
