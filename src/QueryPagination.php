<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query;

class QueryPagination
{
    protected $page = 1;

    protected $perPage = 10;

    public function __construct($page = 1, $perPage = 10)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    /**
     * Check has page or not.
     *
     * @return bool
     */
    public function hasPage()
    {
        return ! is_null($this->page);
    }

    /**
     * Check has PerPage or not.
     *
     * @return bool
     */
    public function hasPerPage()
    {
        return ! is_null($this->perPage);
    }

    /**
     * @return null|int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return static
     */
    public function setPage(int $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return null|int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return static
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function toArray()
    {
        return [
            'page' => $this->getPage(),
            'per_page' => $this->getPerPage(),
        ];
    }
}
