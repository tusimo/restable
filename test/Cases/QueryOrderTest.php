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
class QueryOrderTest extends TestCase
{
    public function testOrder()
    {
        $query = query()->orderBy('id');
        $this->assertEquals($query->getQueryOrderBy()->getOrder(), 'desc');
        $query = query()->orderBy('id', 'asc');
        $this->assertEquals($query->getQueryOrderBy()->getOrder(), 'asc');
        $query = query()->orderBy('id', 'random');
        $this->assertEquals($query->getQueryOrderBy()->getOrder(), 'random');

        $q = $query->fromUriQueryString($query->toUriQueryString());
        $this->assertEquals($q->getQueryOrderBy()->getOrder(), 'random');
        $this->assertEquals($q->getQueryOrderBy()->getOrderBy(), 'id');

        $query = query()->orderBy('id');
        $this->assertEquals($query->getQueryOrderBy()->getOrder(), 'desc');
        $this->assertEquals($query->getQueryOrderBy()->getOrderBy(), 'id');
        $query->orderBy('name', 'random');
        $this->assertEquals($query->getQueryOrderBy()->getOrder(), 'random');
        $this->assertEquals($query->getQueryOrderBy()->getOrderBy(), 'name');
    }
}
