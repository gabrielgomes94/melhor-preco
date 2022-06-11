<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use App\View\Components\Layout;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // @todo: verificar onde esse bind pode ser realizado. Provavelmente num futuro contexto de Application
        Blade::component('layout', Layout::class);
    }
}
