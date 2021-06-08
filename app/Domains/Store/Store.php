<?php

namespace App\Domains\Store;

use App\Domains\User\User;
use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $cnpj
 * @property User $user
 */
class Store extends Model
{
    use HasFactory;

    protected $table = 'store';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return StoreFactory::new();
    }

    public function toArray()
    {
        $relations = ['user' => $this->user->toArray()];
        return array_merge(parent::toArray(), $relations);
    }
}
