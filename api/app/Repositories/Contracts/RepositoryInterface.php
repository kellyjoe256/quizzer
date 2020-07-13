<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function with($relations);

    public function sort(array $sort_order);

    public function paginate(int $limit = 10);

    public function get();

    public function model();
}
