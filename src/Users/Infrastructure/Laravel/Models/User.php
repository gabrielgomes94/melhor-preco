<?php

namespace Src\Users\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Src\Notifications\Domain\Models\Notification;
use Src\Users\Domain\Entities\User as UserInterface;

class User extends Authenticatable implements UserInterface
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

//    use TwoFactorAuthenticatable;

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
        'fiscal_id'
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

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getErp(): ?string
    {
        return $this->erp;
    }

    public function getErpToken(): ?string
    {
        return $this->erp_token;
    }
}
