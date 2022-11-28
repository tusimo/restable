<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query\Concerns;

use Tusimo\Query\QueryAggregate;

trait AggregateAble
{
    /**
     * QueryAggregate.
     *
     * @var QueryAggregate
     */
    protected $queryAggregate;

    /**
     * Add a aggregate.
     *
     * @return static
     */
    public function withAggregate(string $aggregate, string $column)
    {
        if (! $this->hasQueryAggregate()) {
            $this->setQueryAggregate(new QueryAggregate());
        }
        $this->getQueryAggregate()->appendAggregate($aggregate, $column);
        return $this;
    }

    /**
     * Add a aggregates.
     *
     * @return static
     */
    public function withAggregates(string $aggregate, array $columns)
    {
        if (! $this->hasQueryAggregate()) {
            $this->setQueryAggregate(new QueryAggregate());
        }
        $this->getQueryAggregate()->appendAggregates($aggregate, $columns);
        return $this;
    }

    /**
     * Check if has QueryAggregate or not.
     *
     * @return bool
     */
    public function hasQueryAggregate()
    {
        return ! is_null($this->queryAggregate);
    }

    /**
     * Get QueryAggregate.
     *
     * @return QueryAggregate
     */
    public function getQueryAggregate()
    {
        return $this->queryAggregate;
    }

    /**
     * Set the value of queryAggregate.
     *
     * @param mixed $queryAggregate
     * @return static
     */
    public function setQueryAggregate($queryAggregate)
    {
        $this->queryAggregate = $queryAggregate;

        return $this;
    }

    /**
     * Retrieve the "count" result of the query.
     *
     * @param string $columns
     * @return static
     */
    public function count($columns = '*')
    {
        if (is_null($columns)) {
            $columns = [];
        }
        $columns = ! is_array($columns) ? [$columns] : $columns;

        return $this->withAggregates(__FUNCTION__, $columns);
    }

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param string $column
     * @return static
     */
    public function min($column)
    {
        return $this->withAggregates(__FUNCTION__, [$column]);
    }

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param string $column
     * @return static
     */
    public function max($column)
    {
        return $this->withAggregates(__FUNCTION__, [$column]);
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param string $column
     * @return static
     */
    public function sum($column)
    {
        $result = $this->withAggregates(__FUNCTION__, [$column]);

        return $result ?: 0;
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param string $column
     * @return static
     */
    public function avg($column)
    {
        return $this->withAggregates(__FUNCTION__, [$column]);
    }

    /**
     * Alias for the "avg" method.
     *
     * @param string $column
     * @return static
     */
    public function average($column)
    {
        return $this->avg($column);
    }
}
