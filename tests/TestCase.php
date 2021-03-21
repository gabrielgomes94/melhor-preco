<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected const TESTS_FIXTURES_PATH = 'tests/Unit/fixtures';

    protected function fixturePath(string $path = ''): string
    {
        return base_path(static::TESTS_FIXTURES_PATH . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }

    /**
     * @return false|string
     */
    protected function getFixture(string $path)
    {
        return file_get_contents(
            $this->fixturePath($path)
        );
    }

    protected function getJsonFixture(string $path): ?array
    {
        return json_decode($this->getFixture($path), true);
    }
}
