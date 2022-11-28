<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query;

class QuerySelect
{
    /**
     * select resource keys ,empty is all.
     * @var array
     */
    protected $selects = [];

    /**
     * QuerySelect constructor.
     */
    public function __construct(array $selects = [])
    {
        $this->setSelects($selects);
    }

    /**
     * @return array
     */
    public function getSelects()
    {
        return $this->selects;
    }

    public function setSelects(array $selects)
    {
        $this->selects = $this->formatSelect($selects);
        return $this;
    }

    public function appendSelect(array $selects)
    {
        $this->setSelects(array_merge($this->selects, $selects));
        return $this;
    }

    public function hasSubSelect()
    {
        foreach ($this->selects as $select) {
            if (strpos($select, '.') !== false) {
                return true;
            }
        }
        return false;
    }

    public function isSelectAll()
    {
        return empty($this->selects) || (count($this->selects) == 1 && $this->selects[0] == '*');
    }

    public function getResourceSelect()
    {
        $resourceSelects = [];
        foreach ($this->selects as $select) {
            if (strpos($select, '.') === false) {
                if ($select === '*') {
                    return ['*'];
                }
                $resourceSelects[] = $select;
            }
        }
        return $resourceSelects;
    }

    /**
     * Get all sub select resource
     * example: current select is
     * $select = [
     *   'id',
     *   'name',
     *   'detail.id'
     *   'detail.name',
     *   'detail.user.id',
     *   'detail.user.age',
     *   'tags.id',
     *   'tags.name',
     *   'tags.user.id',
     * ]
     * =>
     * return the example below
     * [
     *  'detail' => [
     *    'id',
     *    'name',
     *    'user.id',
     *    'user.age'
     *  ],
     *  'tags' => [
     *    'id',
     *    'name',
     *    'user.id'
     * ]
     * ].
     * @return array
     */
    public function getSubResourceSelect()
    {
        return getArrayByFirstDotElement($this->selects);
    }

    /**
     * Get all sub resource select by key.
     *
     * @param string $key
     */
    public function getSubResourceSelectByKey($key)
    {
        return $this->getSubResourceSelect()[$key] ?? [];
    }

    public function toArray()
    {
        return $this->getSelects();
    }

    /**
     * filter the duplicate select and empty select.
     *
     * @return array
     */
    private function formatSelect(array $select)
    {
        return array_values(array_unique(array_filter($select)));
    }
}
