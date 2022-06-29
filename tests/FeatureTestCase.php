<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected TestResponse $response;
}
