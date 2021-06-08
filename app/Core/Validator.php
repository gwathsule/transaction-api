<?php

namespace App\Core;

use App\Exceptions\ValidationException;
use App\Exceptions\AuthorizationException;
use Illuminate\Support\Facades\Validator as CoreValidator;
use Illuminate\Validation\ValidationException as CoreValidationException;

abstract class Validator
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function isAuthorized()
    {
        return true;
    }

    public function getData()
    {
        return $this->data;
    }

    public function validate()
    {
        $validator = CoreValidator::make(
            $this->data,
            $this->rules(),
        );
        try {
            $validated = $validator->validate();
        } catch (CoreValidationException $e) {
            throw new ValidationException($e->errors(), $e->getMessage());
        }

        if ($this->isAuthorized() === false) {
            throw new AuthorizationException(__('auth.unauthorized'));
        }
        return $validated;
    }
}
