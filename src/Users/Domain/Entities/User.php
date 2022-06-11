<?php

namespace Src\Users\Domain\Entities;

interface User
{
    public function getName(): string;

    public function getFiscalId(): string;

    public function getEmail(): string;

    public function getPhone(): string;
}
