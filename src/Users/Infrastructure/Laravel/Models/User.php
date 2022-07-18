<?php

namespace Src\Users\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Src\Notifications\Domain\Models\Notification;
use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Entities\User as UserInterface;

class User extends Authenticatable implements UserInterface
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'fiscal_id',
        'tax_rate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFiscalId(): string
    {
        return $this->fiscal_id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getErp(): ?string
    {
        return $this->erp;
    }

    public function getErpToken(): ?string
    {
        return $this->erp_token;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getSimplesNacionalTaxRate(): float
    {
        return $this->tax_rate ?? 0.0;
    }

    public function getIcmsInnerStateTaxRate(): float
    {
        return config('taxes.ICMS.MG');
    }

    public function setErp(Erp $erp): void
    {
        $this->erp = $erp->name;
        $this->erp_token = $erp->token;
    }

    public function setPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    }

    public function setProfile(string $name, string $phone, string $fiscalId): void
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->fiscal_id = $fiscalId;
    }

    public function setTaxRate(float $taxRate = 0.0): void
    {
        $this->tax_rate = $taxRate;
    }
}
