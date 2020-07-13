<?php

namespace App\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractModelFilter
{
    protected $request;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function add(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    public function filter(Builder $builder)
    {
        foreach ($this->trimmedFilters() as $filter => $value) {
            $this->resolve($filter)->filter($builder, $value);
        }

        return $builder;
    }

    protected function getFilters()
    {
        return $this->filters;
    }

    protected function trimmedFilters()
    {
        return array_filter(
            $this->request->only(array_keys($this->getFilters()))
        );
    }

    /**
     * Return filter class mapping to a specific query string parameter
     *
     * @param string $filter
     * @return FilterInterface
     */
    protected function resolve($filter)
    {
        return new $this->filters[$filter];
    }
}
