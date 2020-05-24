<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Request;

abstract class AbstractController extends Controller
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $createRequest;

    /**
     * @var string
     */
    protected $updateRequest;

    public function __construct(
        RepositoryInterface $repository,
        string $resource,
        string $createRequest,
        string $updateRequest
    ) {
        $this->repository = $repository;
        $this->resource = $resource;
        $this->createRequest = $createRequest;
        $this->updateRequest = $updateRequest;
    }

    public function store()
    {
        $model = $this->repository->create($this->data());

        return (new $this->resource($model))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id, array $relations = [])
    {
        $model = $this->repository->find($id, $relations);

        return new $this->resource($model);
    }

    public function update($id)
    {
        $model = $this->repository->update($id, $this->data($id));

        return new $this->resource($model);
    }

    public function delete($id)
    {
        $this->repository->delete($id);

        return response()->json(null, 204);
    }

    protected function data($id = null)
    {
        $request_type = $id ? $this->updateRequest : $this->createRequest;
        $request = app()->make($request_type);

        return $this->transform($request);
    }

    protected function transform(Request $request)
    {
        $data = [];
        $pairs = $this->transformFromRequest(); // can_be_admin => is_admin

        foreach ($request->all() as $key => $value) {
            if (array_key_exists($key, $pairs)) {
                $data[$pairs[$key]] = $value;
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Provide a key / value pairing for keys to changed from request
     * to match the model columns
     *
     * @return array
     */
    protected function transformFromRequest()
    {
        return [];
    }
}
