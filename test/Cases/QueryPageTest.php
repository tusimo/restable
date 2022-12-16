<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Test\Cases;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class QueryPageTest extends TestCase
{
    public function testPage()
    {
        $query = query()->page(1, 10);
        $this->assertNotNull($query->getQueryPagination());
        $this->assertNull($query->getQueryCursorPagination());
        $query = query()->cursorPage(1, 10);
        $this->assertNull($query->getQueryPagination());
        $this->assertNotNull($query->getQueryCursorPagination());
        $query = query()->cursorPage(1, 10)
            ->page(1, 10);
        $this->assertNotNull($query->getQueryPagination());
        $this->assertNotNull($query->getQueryCursorPagination());
        $str = $query->toUriQueryString();
        $q = $query->fromUriQueryString($str);
        $this->assertNull($q->getQueryPagination());
        $this->assertNotNull($q->getQueryCursorPagination());
    }
}
