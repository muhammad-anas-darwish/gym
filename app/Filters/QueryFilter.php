<?php 

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class QueryFilter
{
    protected $builder;

    public function apply(Builder $builder, callable $callback)
    {
        $this->builder = $builder;
        $callback($this);
        return $this->builder;
    }

    public function search($key, $value)
    {
        if (!is_null($value)) {
            $this->builder->where($key, 'LIKE', '%' . $value . '%');
        }
        return $this;
    }

    public function where($key, $value)
    {
        if (!is_null($value)) {
            $this->builder->where($key, $value);
        }
        return $this;
    }

    public function orSearch($key, $value)
    {
        if (!is_null($value)) {
            $this->builder->orWhere($key, 'LIKE', '%' . $value . '%');
        }
        return $this;
    }

    public function orWhere($key, $value)
    {
        if (!is_null($value)) {
            $this->builder->orWhere($key, $value);
        }
        return $this;
    }

    public function searchHas($relation, $key, $value)
    {
        if (!is_null($value)) {
            $this->builder->whereHas($relation, function ($query) use ($key, $value) {
                $query->where($key, 'LIKE', '%' . $value . '%');
            });
        }
        return $this;
    }

    public function whereHas($relation, $key, $value)
    {
        if (!is_null($value)) {
            $this->builder->whereHas($relation, function ($query) use ($key, $value) {
                $query->where($key, $value);
            });
        }
        return $this;
    }

    public function orSearchHas($relation, $key, $value)
    {
        if (!is_null($value)) {
            $this->builder->orWhereHas($relation, function ($query) use ($key, $value) {
                $query->where($key, 'LIKE', '%' . $value . '%');
            });
        }
        return $this;
    }

    public function orWhereHas($relation, $key, $value)
    {
        if (!is_null($value)) {
            $this->builder->orWhereHas($relation, function ($query) use ($key, $value) {
                $query->where($key, $value);
            });
        }
        return $this;
    }

    public function group(callable $callback)
    {
        $this->builder->where(function ($query) use ($callback) {
            $filter = new static;
            $filter->apply($query, $callback);
        });
        return $this;
    }
}
