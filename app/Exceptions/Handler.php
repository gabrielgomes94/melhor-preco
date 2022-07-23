<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Products\Domain\Exceptions\ProductNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (MarketplaceNotFoundException $exception, $request) {
            return response()->view('pages.errors.marketplace-404', [
                'identifier' => $exception->identifier,
            ]);
        });

        $this->renderable(function (ProductNotFoundException $exception, $request) {
            return response()->view('pages.errors.product-404', [
                'identifier' => $exception->identifier,
            ]);
        });
    }
}
