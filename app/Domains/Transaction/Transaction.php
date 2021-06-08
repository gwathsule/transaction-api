<?php

namespace App\Domains\Transaction;

use App\Domains\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $amount
 * @property int $payer_id
 * @property int $payee_id
 * @property bool $notified
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $payer
 * @property User $payee
 */
class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'id',
        'amount',
        'payer_id',
        'payee_id',
        'notified',
        'created_at',
        'updated_at',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class);
    }

    public function payee()
    {
        return $this->belongsTo(User::class);
    }

    public function toArray()
    {
        $relations = [
            'payee' => $this->payee->toArray(),
            'payer' => $this->payer->toArray(),
        ];
        return array_merge(parent::toArray(), $relations);
    }
}
