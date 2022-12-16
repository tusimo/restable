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
class QuerySelectTest extends TestCase
{
    public function testSelect()
    {
        $select = ['id', 'name', 'age', 'user.id', 'user.name'];
        $q = query()->select($select);
        $this->assertIsArray($q->getQuerySelect()->getSelects());
        $this->assertEquals($q->getQuerySelect()->getSelects(), $select);

        $select = ['id', 'name', 'id', 'user.id', 'user.name'];
        $q = query()->select($select);
        $this->assertIsArray($q->getQuerySelect()->getSelects());
        $this->assertNotEquals($q->getQuerySelect()->getSelects(), $select);
        $this->assertEquals(count($q->getQuerySelect()->getSelects()), count(array_unique($select)));

        $q = query()->select(['id'])->select(['name', 'age'])->select([])->select([null]);
        $this->assertEquals(count($q->getQuerySelect()->getSelects()), 3);
        $this->assertContains('id', $q->getQuerySelect()->getSelects());
        $this->assertContains('name', $q->getQuerySelect()->getSelects());
        $this->assertContains('age', $q->getQuerySelect()->getSelects());
    }
}
