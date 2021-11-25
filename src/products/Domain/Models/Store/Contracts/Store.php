<?php

namespace Src\Products\Domain\Models\Store\Contracts;

interface Store
{
    public const AMAZON = 'AMAZON';
    public const B2W = 'b2w';
    public const MAGALU = 'magalu';
    public const MERCADO_LIVRE = 'mercado_livre';
    public const OLIST = 'olist';
    public const SHOPEE = 'shopee';
    public const VIA_VAREJO = 'via_varejo';

    public function getSlug(): string;

    public function getName(): string;

    public function getErpCode(): string;

    public function getDefaultCommission(): float;
}
