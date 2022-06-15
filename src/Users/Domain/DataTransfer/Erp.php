<?php

namespace Src\Users\Domain\DataTransfer;

class Erp
{
    public function __construct(
        public readonly string $token,
        public readonly string $name = 'bling'
    ) {
    }
}
