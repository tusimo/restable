<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable;

class QueryWith
{
    protected $with = [];

    /**
     * QueryWith constructor.
     */
    public function __construct(array $with = [])
    {
        $this->setWith($with);
    }

    /**
     * @return array
     */
    public function getWith()
    {
        return $this->with;
    }

    public function setWith(array $with)
    {
        $this->with = $this->formatWith($with);
        return $this;
    }

    public function appendWith(array $with)
    {
        $this->setWith(array_merge($this->with, $with));
        return $this;
    }

    /**
     * Spread with
     * ['user.tags', 'logs', 'account.user.tags'] => ['user', 'user.tags', 'logs', 'account', 'account.user', 'account.user.tags'].
     * @return array
     */
    public function getSpreadWith()
    {
        return spreadArray($this->with);
    }

    public function toArray()
    {
        return $this->getWith();
    }

    private function formatWith(array $with)
    {
        return array_values(array_unique(array_filter($with)));
    }
}
