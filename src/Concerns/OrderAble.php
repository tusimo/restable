<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

use Tusimo\Restable\QueryOrderBy;

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
    public function orderBy(string $orderBy, string $order = 'desc')
    {
        $queryOrderBy = new QueryOrderBy();
        $queryOrderBy->setOrder($order)->setOrderBy($orderBy);
        $this->setQueryOrderBy($queryOrderBy);
        return $this;
    }

    /**
     * @return $this
     */
    public function orderByDesc(string $orderBy)
    {
        $this->orderBy($orderBy, 'desc');
        return $this;
    }

    /**
     * @return $this
     */
    public function orderByAsc(string $orderBy)
    {
        $this->orderBy($orderBy, 'asc');
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
