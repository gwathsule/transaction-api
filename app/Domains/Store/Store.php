<?php

namespace App\Domains\Store;

use App\Domains\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cnpj
 */
class Store extends Model
{
    public function user(){
        return $this->morphOne(User::class, 'userable');
    }
}
