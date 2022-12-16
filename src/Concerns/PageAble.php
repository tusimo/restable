<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

use Tusimo\Restable\QueryPagination;
use Tusimo\Restable\QueryCursorPagination;

trait PageAble
{
    /**
     * @var QueryPagination
     */
    protected $queryPagination;

    /**
     * @var QueryCursorPagination
     */
    protected $queryCursorPagination;

    /**
     * Set QueryPagination.
     *
     * @return static
     */
    public function setQueryPagination(QueryPagination $queryPagination)
    {
        $this->queryPagination = $queryPagination;
        return $this;
    }

    public function setQueryCursorPagination(QueryCursorPagination $queryCursorPagination)
    {
        $this->queryCursorPagination = $queryCursorPagination;
        return $this;
    }

    public function hasQueryCursorPagination()
    {
        return ! is_null($this->getQueryCursorPagination());
    }

    /**
     * Check if has pagination or not.
     *
     * @return bool
     */
    public function hasQueryPagination()
    {
        return ! is_null($this->getQueryPagination());
    }

    public function getQueryCursorPagination()
    {
        return $this->queryCursorPagination;
    }

    /**
     * Get the value of queryPagination.
     *
     * @return QueryPagination
     */
    public function getQueryPagination()
    {
        return $this->queryPagination;
    }

    /**
     * @param mixed $cursor
     * @param mixed $perPage
     * @return static
     */
    public function cursorPage($cursor, $perPage = 10)
    {
        $this->setQueryCursorPagination(new QueryCursorPagination($cursor, $perPage));
        return $this;
    }

    /**
     * @return static
     */
    public function page(int $page = 1, int $perPage = 10)
    {
        $this->setQueryPagination(new QueryPagination($page, $perPage));
        return $this;
    }
}
