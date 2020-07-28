<?php


namespace Repository;


use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * Define relevant model
     *
     * @return Model
     */
    abstract public function model();

    public function getAll()
    {
        return $this->model()::all();
    }

    public function findOrFail($primaryKey)
    {
        return $this->model()::findOrFail($primaryKey);
    }

    public function delete($rowId)
    {
        return $this->model()::destroy($rowId);
    }

    public function create(array $data)
    {
        return $this->model()::create($data);
    }

    public function update(Model $model, array $data)
    {
        return $model->update($data);
    }
}
