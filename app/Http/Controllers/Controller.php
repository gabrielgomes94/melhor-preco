<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Src\Users\Domain\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getUser(): ?User
    {
        return auth()->user();
    }

    protected function getUserId(): string
    {
        return auth()->user()?->getAuthIdentifier() ?? '';
    }

    protected function getUserErpToken(): string
    {
        return auth()->user()?->getErpToken() ?? '';
    }
}
