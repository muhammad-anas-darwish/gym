<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class Filter
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function search(array $rules): Filter
    {
        if ($rules[key($rules)]) {
            $this->query->where(function($query) use ($rules) {
                $query->where(key($rules), 'LIKE', '%' . $rules[key($rules)] . '%');
                $rules = array_slice($rules, 1);
                foreach ($rules as $key => $value) {
                    $query->orWhere($key, 'LIKE', '%' . $value . '%');
                }
            });
        }

        return $this;
    }

    public function whereHas(string $relationshipName, string $fieldName, ?int $id): Filter
    {
        if ($id) {
            $this->query->whereHas($relationshipName, function ($query) use ($fieldName, $id) {
                $query->where($fieldName, $id);
            });
        }

        return $this;
    }

    public function whereHasByColumn(string $relationshipName, string $fieldName, ?string $value): Filter
    {
        if ($value) {
            $this->query->whereHas($relationshipName, function ($query) use ($fieldName, $value) {
                $query->where($fieldName, 'LIKE', '%' . $value . '%');
            });
        }

        return $this;
    }

    public function where(string $fieldName, $value): Filter
    {
        if ($value !== null) {
            $this->query->where($fieldName, $value);
        }

        return $this;
    }

    public function orderBy(array $columns, ?string $value, string $order = 'desc'): Filter
    {
        if ($value) {
            foreach ($columns as $column) {
                if ($column === $value) {
                    $this->query->orderBy($column, $order);
                }
            }
        }

        return $this;
    }
}
