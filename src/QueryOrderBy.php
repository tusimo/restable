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

    public function hasOrderBy()
    {
        return ! is_null($this->orderBy);
    }

    public function hasOrder()
    {
        return ! is_null($this->order);
    }

    /**
     * @return null|string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     * @return static
     */
    public function setOrder($order)
    {
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
