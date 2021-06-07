<?php

namespace App\Domains\Store;

use App\Domains\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $cnpj
 * @property User $user
 */
class Store extends Model
{
    protected $table = 'store';
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
