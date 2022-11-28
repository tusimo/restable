<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

use Tusimo\Restable\QueryPagination;

trait PageAble
{
    /**
     * @var QueryPagination
     */
    protected $queryPagination;

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

    /**
     * Check if has pagination or not.
     *
     * @return bool
     */
    public function hasQueryPagination()
    {
        return ! is_null($this->getQueryPagination());
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
     * @return $this
     */
    public function page(int $page = 1, int $perPage = 10)
    {
        $this->setQueryPagination(new QueryPagination($page, $perPage));
        return $this;
    }
}
