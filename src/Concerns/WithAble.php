<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query\Concerns;

use Tusimo\Query\QueryWith;

trait WithAble
{
    /**
     * @var QueryWith
     */
    protected $queryWith;

    /**
     * @param array $with
     * @return $this
     */
    public function with($with)
    {
        $with = is_array($with) ? $with : func_get_args();
        $this->getQueryWith()->appendWith($with);
        return $this;
    }

    /**
     * Set QueryWith.
     *
     * @return static
     */
    public function setQueryWith(QueryWith $queryWith)
    {
        $this->queryWith = $queryWith;
        return $this;
    }

    /**
     * Check has QueryWith or Not.
     *
     * @return bool
     */
    public function hasQueryWith()
    {
        return ! is_null($this->queryWith);
    }

    /**
     * Get the value of queryWith.
     *
     * @return QueryWith
     */
    public function getQueryWith()
    {
        if (! $this->hasQueryWith()) {
            $this->queryWith = new QueryWith([]);
        }
        return $this->queryWith;
    }
}
