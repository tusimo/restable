<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable;

class QueryAggregate
{
    private const OPERATIONS = [
        'count',
        'sum',
        'avg',
        'min',
        'max',
    ];

    protected $aggregates = [];

    /**
     * Append one aggregate.
     *
     * @return static
     */
    public function appendAggregate(string $aggregate, string $column)
    {
        if (! in_array($aggregate, self::OPERATIONS)) {
            throw new \RuntimeException("aggregate:{$aggregate} not supported");
        }
        $columns = $this->getAggregateColumns($aggregate);
        $this->aggregates[$aggregate] = array_unique(array_merge($columns, [$column]));

        return $this;
    }

    /**
     * Append aggregates.
     *
     * @param array $column
     *
     * @return static
     */
    public function appendAggregates(string $aggregate, array $columns)
    {
        foreach ($columns as $column) {
            $this->appendAggregate($aggregate, $column);
        }
        return $this;
    }

    /**
     * Get Aggregates.
     *
     * @return array
     */
    public function getAggregates()
    {
        return $this->aggregates;
    }

    /**
     * Get Aggregate Columns.
     *
     * @param string $column
     *
     * @return array
     */
    public function getAggregateColumns(string $aggregate)
    {
        return $this->aggregates[$aggregate] ?? [];
    }
}
