<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

use Tusimo\Restable\Query;

trait CloneAble
{
    public function __clone()
    {
        foreach ($this as $key => $val) {
            if (is_object($val) || is_array($val)) {
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }

    /**
     * @return Query
     */
    public function newQuery()
    {
        $query = new Query();
        if ($this->getQuerySelect()) {
            $query->setQuerySelect($this->getQuerySelect());
        }
        if ($this->getQueryWith()) {
            $query->setQueryWith($this->getQueryWith());
        }
        if ($this->getQuerySeek()) {
            $query->setQuerySeek($this->getQuerySeek());
        }
        if ($this->getQueryPagination()) {
            $query->setQueryPagination($this->getQueryPagination());
        }
        if ($this->getQueryCursorPagination()) {
            $query->setQueryCursorPagination($this->getQueryCursorPagination());
        }
        if ($this->getQueryOrderBy()) {
            $query->setQueryOrderBy($this->getQueryOrderBy());
        }
        if ($this->getQueryAggregate()) {
            $query->setQueryAggregate($this->getQueryAggregate());
        }
        if ($this->getQueryItems()) {
            $query->setQueryItems($this->getQueryItems());
        }
        if ($this->getParameters()) {
            $query->setParameters($this->getParameters());
        }
        return $query;
    }
}
