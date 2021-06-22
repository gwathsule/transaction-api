<?php

namespace App\Http\Controllers;

use App\Domains\Store\Services\CreateStore;
use App\Domains\Store\Services\ListStores;
use App\Domains\Store\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StoreController extends Controller
{
    private CreateStore $createStoreService;
    private ListStores $listStores;

    public function __construct(
        CreateStore $createStoreService,
        ListStores $listStores
    ) {
        $this->listStores = $listStores;
        $this->createStoreService = $createStoreService;
    }

    public function createStore(Request $request)
    {
        /** @var Store $store */
        $store = $this->createStoreService->handle($request->toArray());
        return $this->buildSuccessfulResponse($store->toArray());
    }

    public function listStores()
    {
        /** @var Collection $list */
        $list = $this->listStores->handle();
        return $this->buildSuccessfulResponse($list->toArray());
    }
}
