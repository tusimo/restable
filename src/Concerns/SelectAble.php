<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

use Tusimo\Restable\QuerySelect;

trait SelectAble
{
    /**
     * @var QuerySelect
     */
    protected $querySelect;

    /**
     * Get Query Select.
     *
     * @return QuerySelect
     */
    public function getQuerySelect()
    {
        if (! $this->hasQuerySelect()) {
            $this->querySelect = new QuerySelect([]);
        }
        return $this->querySelect;
    }

    /**
     * Has QuerySelect or not.
     *
     * @return bool
     */
    public function hasQuerySelect()
    {
        return ! is_null($this->querySelect);
    }

    /**
     * Set Query Select.
     *
     * @return static
     */
    public function setQuerySelect(QuerySelect $querySelect)
    {
        $this->querySelect = $querySelect;
        return $this;
    }

    /**
     * @param array $select
     * @return $this
     */
    public function select($select)
    {
        $select = is_array($select) ? $select : func_get_args();
        $this->getQuerySelect()->appendSelect($select);
        return $this;
    }
}
