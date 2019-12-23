<?php

namespace App\Repositories;

class AbstractRepository implements AbstractInterface
{
    protected $model;

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getAll(int $limit = 10)
    {
        return $this->model->select()
                ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * @return mixed
     */
    public function getAllNoLimit()
    {
        return $this->model->select()
            ->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param int $id
     * @param array $attributes
     * @param bool $getDataBack
     * @return mixed
     */
    public function update(int $id, array $attributes, bool $getDataBack = false)
    {
        $object = $this->model->findOrFail($id);
        $object->update($attributes);
        if ($getDataBack) {
            return $object;
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function remove(int $id)
    {
        $item = $this->model->findOrFail($id);
        $item->delete();
        return $item;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $data = $this->model->create($attributes);
        return $this->model->find($data->id);
    }
}
