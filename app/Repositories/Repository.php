<?php

namespace App\Repositories;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    abstract public function getModel();

    public function __get($field)
    {
        return $field === 'model' ? $this->model : null;
    }

    public function __set($field, $value)
    {
        if ($field == 'model') {
            $this->model = $value;
        }
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($record, array $data)
    {
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
