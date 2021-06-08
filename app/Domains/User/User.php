<?php

namespace App\Domains\User;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property boolean $isStore
 * @property string $name
 * @property string $cpf
 * @property string $email
 * @property string $password
 * @property float $balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    use HasFactory;

    public const TYPE_CUSTOMER = 1;
    public const TYPE_STORE = 1;

    protected $table = 'user';

    protected $fillable = [
        'type',
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

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
