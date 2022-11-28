<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query\Concerns;

use Tusimo\Query\QuerySeek;

trait SeekAble
{
    /**
     * @var QuerySeek
     */
    protected $querySeek;

    /**
     * Check has QuerySeek Or not.
     *
     * @return bool
     */
    public function hasQuerySeek()
    {
        return ! is_null($this->querySeek);
    }

    /**
     * Get the value of querySeek.
     *
     * @return QuerySeek
     */
    public function getQuerySeek()
    {
        return $this->querySeek;
    }

    /**
     * Set the value of querySeek.
     *
     * @return self
     */
    public function setQuerySeek(QuerySeek $querySeek)
    {
        $this->querySeek = $querySeek;

        return $this;
    }

    /**
     * Set Offset.
     *
     * @return static
     */
    public function offset(int $offset)
    {
        if (! $this->hasQuerySeek()) {
            $this->setQuerySeek(new QuerySeek());
        }
        $this->getQuerySeek()->setOffset($offset);
        return $this;
    }

    /**
     * set Skip as offset alias.
     *
     * @return static
     */
    public function skip(int $skip)
    {
        return $this->offset($skip);
    }

    /**
     * Set limit.
     *
     * @return static
     */
    public function limit(int $limit)
    {
        if (! $this->hasQuerySeek()) {
            $this->setQuerySeek(new QuerySeek());
        }
        $this->getQuerySeek()->setLimit($limit);
        return $this;
    }

    /**
     * Set take as limit alias.
     *
     * @return static
     */
    public function take(int $value)
    {
        return $this->limit($value);
    }
}
