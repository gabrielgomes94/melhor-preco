<?php

namespace Src\Products\Application\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Src\Products\Domain\Events\Product\ProductsSynchronized;

class LogProductsSynchronized
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Src\Products\Domain\Events\Product\ProductsSynchronized  $event
     * @return void
     */
    public function handle(ProductsSynchronized $event)
    {
        $createdCount = $event->createdCount();
        $updatedCount = $event->updatedCount();

        Log::info("Os produtos foram sincronizados com sucesso. {$createdCount} novos produtos foram criados e {$updatedCount} foram atualizados");
    }
}
