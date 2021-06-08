<?php

namespace App\Http\Controllers;

use App\Domains\Store\Services\CreateStore;
use App\Domains\Store\Services\ListStores;
use App\Domains\Store\Store;
use App\Exceptions\InternalServerException;
use App\Exceptions\UserException;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Exception;
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
        try {
            /** @var Store $store */
            $store = $this->createStoreService->handle($request->toArray());
            return $this->buildSuccessfulResponse($store->toArray());
        } catch (ValidationException $exception) {
            return $this->buildUserErrorResponse(
                $exception->getUserMessage(),
                $exception->getCategory(),
                $exception->getStatus(),
                $exception->getErrors()
            );
        } catch (UserException $exception) {
            return $this->buildUserErrorResponse(
                $exception->getUserMessage(),
                $exception->getCategory(),
                $exception->getStatus(),
            );
        } catch (Exception $exception) {
            return $this->buildUserErrorResponse(
                InternalServerException::USER_MESSAGE,
                InternalServerException::CATEGORY,
                InternalServerException::STATUS
            );
        }
    }

    public function listStores()
    {
        try {
            /** @var Collection $list */
            $list = $this->listStores->handle();
            return $this->buildSuccessfulResponse($list->toArray());
        } catch (Exception $exception) {
            return $this->buildUserErrorResponse(
                InternalServerException::USER_MESSAGE,
                InternalServerException::CATEGORY,
                InternalServerException::STATUS
            );
        }
    }
}
