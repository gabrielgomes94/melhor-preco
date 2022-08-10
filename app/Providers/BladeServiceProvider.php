<?php

namespace App\Providers;

use App\View\Components\GuestLayout;
use App\View\Components\Layout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component('layout', Layout::class);
        Blade::component('layout-guest', GuestLayout::class);
    }
}
