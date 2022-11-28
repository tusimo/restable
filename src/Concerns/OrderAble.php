<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query\Concerns;

use Tusimo\Query\QueryOrderBy;

trait OrderAble
{
    /**
     * @var QueryOrderBy
     */
    protected $queryOrderBy;

    /**
     * Set QueryOrderBy.
     *
     * @return static
     */
    public function setQueryOrderBy(QueryOrderBy $queryOrderBy)
    {
        $this->queryOrderBy = $queryOrderBy;
        return $this;
    }

    /**
     * Get the value of queryOrderBy.
     *
     * @return QueryOrderBy
     */
    public function getQueryOrderBy()
    {
        return $this->queryOrderBy;
    }

    /**
     * Check if has queryOrderBy or not.
     *
     * @return bool
     */
    public function hasQueryOrderBy()
    {
        return ! is_null($this->getQueryOrderBy());
    }

    /**
     * @return static
     */
    public function orderBy(string $key, string $direction = 'desc')
    {
        $this->setQueryOrderBy(new QueryOrderBy($key, $direction));
        return $this;
    }

    /**
     * @param string $direction
     * @return $this
     */
    public function orderByDesc(string $key)
    {
        $this->orderBy($key, 'desc');
        return $this;
    }

    /**
     * @param string $direction
     * @return $this
     */
    public function orderByAsc(string $key)
    {
        $this->orderBy($key, 'asc');
        return $this;
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param string $column
     * @return static
     */
    public function latest($column = 'created_at')
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param string $column
     * @return static
     */
    public function oldest($column = 'created_at')
    {
        return $this->orderBy($column, 'asc');
    }
}
