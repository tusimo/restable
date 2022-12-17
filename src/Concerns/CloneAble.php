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

    public function newQuery()
    {
        return (new Query())->setQuerySelect($this->getQuerySelect())
            ->setQueryWith($this->getQueryWith())
            ->setQuerySeek($this->getQuerySeek())
            ->setQueryPagination($this->getQueryPagination())
            ->setQueryCursorPagination($this->getQueryCursorPagination())
            ->setQueryOrderBy($this->getQueryOrderBy())
            ->setQueryAggregate($this->getQueryAggregate())
            ->setQueryItems($this->getQueryItems())
            ->setParameters($this->getParameters());
    }
}
