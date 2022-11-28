<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

use Tusimo\Restable\QueryItem;

trait QueryAble
{
    /**
     * @var QueryItem[]
     */
    protected $queryItems = [];

    /**
     * Add a QueryItem to the Query.
     *
     * @return static
     */
    public function withQueryItem(QueryItem $queryItem)
    {
        $this->queryItems[] = $queryItem;
        return $this;
    }

    /**
     * Set all query queryItems.
     *
     * @return static
     */
    public function setQueryItems(array $queryItems)
    {
        $this->queryItems = $queryItems;
        return $this;
    }

    /**
     * Get the value of queryItems.
     *
     * @return QueryItem[]
     */
    public function getQueryItems()
    {
        return $this->queryItems;
    }

    /**
     * @param mixed $value
     * @param mixed $operation
     * @return $this
     */
    public function where(string $key, $operation, $value = null)
    {
        if ($value === null) {
            $this->withQueryItem(new QueryItem($key, 'eq', $operation));
            return $this;
        }
        $this->withQueryItem(new QueryItem($key, $operation, $value));
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function whereIn(string $key, $value)
    {
        $this->withQueryItem(new QueryItem($key, 'in', is_array($value) ? $value : [$value]));
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function whereNotIn(string $key, $value)
    {
        $this->withQueryItem(new QueryItem($key, 'not_in', is_array($value) ? $value : [$value]));
        return $this;
    }

    /**
     * @return $this
     */
    public function whereBetween(string $key, array $value)
    {
        $this->withQueryItem(new QueryItem($key, 'between', $value));
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function whereNotBetWeen(string $key, array $value)
    {
        $this->withQueryItem(new QueryItem($key, 'not_between', $value));
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function whereNull(string $key)
    {
        $this->withQueryItem(new QueryItem($key, 'null', null));
        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function whereNotNull(string $key)
    {
        $this->withQueryItem(new QueryItem($key, 'not_null', null));
        return $this;
    }

    /**
     * whereLike.
     *
     * @return $this
     */
    public function whereLike(string $key, string $value)
    {
        $this->withQueryItem(new QueryItem($key, 'like', $value));
        return $this;
    }
}
