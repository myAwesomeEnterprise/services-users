<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getModel();

    public function all();

    public function create(array $data);

    public function show($id);

    public function update($record, array $data);

    public function delete($id);
}
