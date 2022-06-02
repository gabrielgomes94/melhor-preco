<?php

namespace Tests\Helpers;

use Exception;
use PHPUnit\Framework\TestCase;

trait AssertUuidHelper
{
    /**
     * @throws Exception
     */
    public function assertIsUuid(mixed $uuid): void
    {
        if (!$this instanceof TestCase) {
            throw new Exception('Invalid type: this trait must be used in a TestCase class');
        }

        $this->assertTrue($this->validateUuid($uuid));
    }

    private function validateUuid(mixed $uuid): bool
    {
        $uuid4_regex = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

        if (!is_string($uuid) || (preg_match($uuid4_regex, $uuid) !== 1)) {
            return false;
        }

        return true;
    }
}
