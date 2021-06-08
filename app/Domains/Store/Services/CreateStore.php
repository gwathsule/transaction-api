<?php

namespace App\Domains\Store\Services;

use App\Core\Service;
use App\Domains\Store\Store;
use App\Domains\Store\StoreRepository;
use App\Domains\Store\Validators\CreateStoreValidator;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateStore extends Service
{
    private StoreRepository $storeRepository;
    private UserRepository $userRepository;

    public function __construct(
        StoreRepository $storeRepository,
        UserRepository  $userRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->userRepository = $userRepository;
    }

    public function validate(array $data)
    {
        $validator = new CreateStoreValidator($data);
        return $validator->validate();
    }

    protected function perform(array $data)
    {
        DB::beginTransaction();
        try {
            $userStore = new User();
            $userStore->name = $data['name'];
            $userStore->cpf = $data['cpf'];
            $userStore->email = $data['email'];
            $userStore->password = $data['password'];
            $userStore->balance = 0;
            $userStore->isStore = true;
            $this->userRepository->save($userStore);

            $store = new Store();
            $store->cnpj = $data['cnpj'];
            $store->user_id = $userStore->id;
            $this->storeRepository->save($store);
        } catch (Exception $exception) {
            throw $exception;
        }
        DB::commit();
        return $store;
    }
}
