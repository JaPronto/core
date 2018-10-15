<?php

namespace App\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    /**
     * @return Builder
     */
    protected function newQuery()
    {
        return resolve($this->model)->newQuery();
    }

    /**
     * @param null $query
     * @param int $take
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate) {
            return $query->paginate($take);
        }

        if ($take > 0 || $take !== false) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * @param $take
     * @param $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($take, $paginate)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param $column
     * @param null $key
     * @return array
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * @param $id
     * @param bool $fail
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function findById($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }
        return $this->newQuery()->find($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return Model
     */
    public function updateById($id, array $data)
    {
        $model = $this->findById($id);

        return $this->updateByModel($model, $data);
    }

    /**
     * @param $model
     * @param array $data
     * @return Model
     */
    public function updateByModel(Model $model, array $data)
    {
        $model->update($data);

        return $model->fresh();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $model = $this->findById($id);

        return $this->deleteByModel($model);
    }

    /**
     * @param $model
     * @return bool
     * @throws \Exception
     */
    public function deleteByModel(Model $model)
    {
        return $model->delete();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $query = $this->newQuery();

        return $query->create($data);
    }
}