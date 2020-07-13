<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $entity;

    /**
     * @var Builder|Model
     */
    protected $builder;

    public function __construct()
    {
        $entity = $this->resolveEntity();

        $this->entity = $entity;
        $this->builder = $entity;
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function find($id)
    {
        return $this->select()->findOrFail($id);
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

    public function with($relations)
    {
        $relations = is_array($relations) ? $relations : func_get_args();
        $this->builder = $this->builder->with($relations);

        return $this;
    }

    public function sort(array $sort_order)
    {
        foreach ($sort_order as $column => $direction) {
            $this->builder->orderBy($column, $direction);
        }

        return $this;
    }

    public function paginate(int $limit = 10)
    {
        return $this->select()->paginate($limit);
    }

    public function get()
    {
        return $this->select()->get();
    }

    public function model()
    {
        return $this->entity;
    }

    protected function select()
    {
        return $this->builder->select($this->columns());
    }

    protected function columns(): array
    {
        return ['*'];
    }

    protected function resolveEntity(): Model
    {
        if (!method_exists($this, 'entity')) {
            throw new \Exception('Method `entity` not defined');
        }

        return app()->make($this->entity());
    }

    abstract protected function entity(): string;
}
