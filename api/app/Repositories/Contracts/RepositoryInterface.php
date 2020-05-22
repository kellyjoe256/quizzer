<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function paginate(array $sort_order, array $relations = []);

    public function find($id, array $relations = []);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
