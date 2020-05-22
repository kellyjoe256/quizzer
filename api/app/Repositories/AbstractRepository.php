<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function paginate(array $sort_order, array $relations = [])
    {
        $query = $this->entity->with($relations);
        $this->orderResultSet($query, $sort_order);

        return $query->paginate(config('custom.per_page', 10));
    }

    public function find($id, array $relations = [])
    {
        return $this->entity->with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        $model->delete();

        return $model;
    }

    protected function orderResultSet($query, array $sort_order): void
    {
        foreach ($sort_order as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }

    protected function resolveEntity(): Model
    {
        if (!method_exists($this, 'entity')) {
            throw new \Exception('Method `entity` not defined');
        }

        return app()->make($this->entity());
    }

    abstract protected function entity();
}
