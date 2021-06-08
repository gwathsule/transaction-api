<?php

namespace App\Domains\Store\Services;

use App\Core\Service;
use App\Domains\Store\StoreRepository;

class ListStores extends Service
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function validate(array $data)
    {
        return [];
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function perform(array $data)
    {
        return $this->storeRepository->all();
    }
}
