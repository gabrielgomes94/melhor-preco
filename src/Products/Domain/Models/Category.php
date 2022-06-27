<?php

namespace Src\Products\Domain\Models;

interface Category
{
    public function getCategoryId(): string;

    public function getFullName(): string;

    public function getName(): string;

    public function getParentId(): string;
}
