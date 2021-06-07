<?php

namespace App\Domains\User;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * @property int $id
 * @property string $name
 * @property string $cpf
 * @property string $email
 * @property string $password
 * @property float $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'balance',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function userable()
    {
        return $this->morphTo();
    }
}
