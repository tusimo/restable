<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query\Concerns;

trait SubResourceAble
{
    /**
     * Add Sub Resource selects.
     *
     * @param array $selects
     *
     * @return static
     */
    public function selectSubResource(string $resource, $selects = [])
    {
        $resourceSelects = [];
        foreach ($selects as $select) {
            $resourceSelects[] = $resource . '.' . $select;
        }
        return $this->select($resourceSelects);
    }

    /**
     * Get Current Resource QueryItems.
     *
     * @return array
     */
    public function getResourceQueryItems()
    {
        $queryItems = [];
        foreach ($this->getQueryItems() as $queryItem) {
            if (! $queryItem->isSubQuery()) {
                $queryItems[] = $queryItem;
            }
        }
        return $queryItems;
    }

    /**
     * Get Sub Resource QueryItems.
     *
     * @return array
     */
    public function getSubResourceQueryItems()
    {
        $queryItems = [];
        foreach ($this->getQueryItems() as $queryItem) {
            if ($queryItem->isSubQuery()) {
                $temps = explode('.', $queryItem->getName());
                $key = $temps[0];
                $value = implode('.', array_slice($temps, 1));
                $queryItem->setName($value);
                $queryItems[$key][] = $queryItem;
            }
        }
        return $queryItems;
    }

    public function getSubResourceQueryItemsByKey(string $key)
    {
        return $this->getSubResourceQueryItems()[$key] ?? [];
    }
}
