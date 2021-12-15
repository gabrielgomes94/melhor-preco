<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Src\Products\Domain\Models\Product\Product;

class ImportCostsBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import-costs-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'IMport products backup costs on s3';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $json = Storage::get('/_backup_product_costs/barrigudinha-products-backup.json');
        $data = json_decode($json, true);

        foreach ($data['products'] as $product) {
            $productModel = Product::where('sku', $product['sku'])->first();

            if (!$productModel) {
                continue;
            }

            $productModel->purchase_price = (float) $product['purchase_price'] ?? 0.0;
            $productModel->tax_icms = (float) $product['tax_icms'] ?? 0.0;

            $productModel->save();
        }

        return 0;
    }
}
