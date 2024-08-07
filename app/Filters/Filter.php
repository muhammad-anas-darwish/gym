<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class Filter
{
    public function __construct(protected Builder $query)
    { }

    /**
     * Search for records based on the provided rules.
     *
     * @param array $rules
     * @param string $conditionType
     * @return Filter
     */
    public function search(array $rules, string $conditionType = 'orWhere'): Filter
    {
        $filteredRules = array_filter($rules, function ($value) {
            return !is_null($value);
        });

        if (!empty($filteredRules)) {
            $this->query->where(function($query) use ($filteredRules, $conditionType) {
                foreach ($filteredRules as $key => $value) {
                    $query->{$conditionType}($key, 'LIKE', '%' . $value . '%');
                }
            });
        }

        return $this;
    }

    /**
     * Add a relationship constraint to the query.
     *
     * @param string $relationshipName
     * @param string $fieldName
     * @param mixed $value
     * @return Filter
     */
    public function whereHas(string $relationshipName, string $fieldName, mixed $value): Filter
    {
        if (!is_null($value)) {
            $this->query->whereHas($relationshipName, function ($query) use ($fieldName, $value) {
                $query->where($fieldName, $value);
            });
        }

        return $this;
    }

    /**
     * Add a relationship constraint to the query based on a column value.
     *
     * @param string $relationshipName
     * @param string $fieldName
     * @param string|null $value
     * @return Filter
     */
    public function whereHasByColumn(string $relationshipName, string $fieldName, ?string $value): Filter
    {
        if ($value) {
            $this->query->whereHas($relationshipName, function ($query) use ($fieldName, $value) {
                $query->where($fieldName, 'LIKE', '%' . $value . '%');
            });
        }

        return $this;
    }

    /**
     * Add a basic WHERE clause to the query based on the given field and value.
     *
     * @param string $fieldName
     * @param mixed $value
     * @return Filter
     */
    public function where(string $fieldName, $value): Filter
    {
        if ($value !== null) {
            $this->query->where($fieldName, $value);
        }

        return $this;
    }

    /**
     * Add an ORDER BY clause to the query based on the specified columns and order direction.
     *
     * @param array $columns
     * @param string|null $value
     * @param string $order
     * @return Filter
     */
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
