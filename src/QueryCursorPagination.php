<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable;

class QueryCursorPagination
{
    protected $cursor = '';

    protected $perPage = 10;

    public function __construct($cursor = '', $perPage = 10)
    {
        $this->cursor = $cursor;
        $this->perPage = $perPage;
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
            'cursor' => $this->getCursor(),
            'per_page' => $this->getPerPage(),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * @param mixed|string $cursor
     * @return static
     */
    public function setCursor($cursor)
    {
        $this->cursor = $cursor;
        return $this;
    }
}
