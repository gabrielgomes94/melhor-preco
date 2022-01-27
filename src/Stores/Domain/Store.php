<?php

namespace Src\Stores\Domain;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'erp_id',
        'erp_name',
        'name',
        'slug',
        'extra',
        'uuid',
    ];

//    public static function findByErpId(string $erpId): self
//    {
//
//    }
//
//    public static function findBySlug(string $slug): self
//    {
//
//    }
}
