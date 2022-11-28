<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable;

class QueryOrderBy
{
    /**
     * Order column.
     *
     * @var null|string
     */
    protected $orderBy;

    /**
     * Order direction, asc or desc.
     *
     * @var null|string
     */
    protected $order;

    public function __construct(string $orderBy = 'id', string $order = 'desc')
    {
        $this->orderBy = $orderBy;
        $this->order = $order;
    }

    /**
     * Check if has order or not.
     *
     * @return bool
     */
    public function hasOrder()
    {
        return ! is_null($this->order);
    }

    /**
     * Check if has order or not.
     *
     * @return bool
     */
    public function hasOrderBy()
    {
        return ! is_null($this->orderBy);
    }

    /**
     * @return null|string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function setOrderBy(string $orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return null|string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $orderByDirection
     * @return static
     */
    public function setOrder(string $order)
    {
        if (! in_array($order, ['asc', 'desc'])) {
            throw new \RuntimeException("order by operation: {$order} is not supported");
        }
        $this->order = $order;
        return $this;
    }

    public function toArray()
    {
        return [
            'order' => $this->getOrder(),
            'order_by' => $this->getOrderBy(),
        ];
    }
}
