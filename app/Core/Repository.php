<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * Define the repository model class
     * @return string|Model
     */
    abstract public function getModel(): string;

    /**
     * Get a new query builder.
     *
     * @return Builder
     */
    protected function newQuery()
    {
        return $this->getModel()::query();
    }

    /**
     * Retrieve model by id.
     *
     * @param mixed $keyValue
     * @param string $keyName
     * @param array $relations
     * @return Model|null
     */
    public function getById($keyValue, string $keyName = 'id', array $relations = [])
    {
        return $this->newQuery()
            ->with($relations)
            ->where($keyName, $keyValue)
            ->first();
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function save(Model $model)
    {
        return $model->save();
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function update(Model $model)
    {
        return $model->save();
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

}
