<?php

namespace App\Http\Controllers;

use App\Domains\Transaction\Services\PerformTransaction;
use Illuminate\Http\Request;

class TransactionController
{
    public function performTransaction(Request $request)
    {
        $service = new PerformTransaction($request->toArray());
    }
}
