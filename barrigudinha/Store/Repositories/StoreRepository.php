<?php

namespace Barrigudinha\Store\Repositories;

interface StoreRepository
{
    public const AMAZON = 'AMAZON';
    public const B2W = 'b2w';
    public const MAGALU = 'magalu';
    public const MERCADO_LIVRE = 'mercado_livre';
    public const OLIST = 'olist';
    public const SHOPEE = 'shopee';
    public const VIA_VAREJO = 'via_varejo';

    /**
     * @return string[]
     */
    public function all(): array;
}
