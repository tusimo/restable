<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query;

class QuerySeek
{
    protected $offset;

    protected $limit;

    /**
     * Check if has offset or not.
     *
     * @return bool
     */
    public function hasOffset()
    {
        return ! is_null($this->offset);
    }

    /**
     * Check if has limit or not.
     *
     * @return bool
     */
    public function hasLimit()
    {
        return ! is_null($this->limit);
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return static
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return static
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function toArray()
    {
        return [
            'offset' => $this->getOffset(),
            'limit' => $this->getLimit(),
        ];
    }
}
