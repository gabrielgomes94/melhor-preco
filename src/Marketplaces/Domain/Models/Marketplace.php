<?php

namespace Src\Marketplaces\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'erp_id',
        'erp_name',
        'name',
        'slug',
        'extra',
        'uuid',
    ];

    protected $casts = [
        'extra' => 'json',
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    public function getCommissionType(): string
    {
        return $this->extra['commissionType'];
    }

    public function getErpId(): string
    {
        return $this->erp_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCommissionValues(): string
    {
        return '0%; 7,99%';
    }
}
