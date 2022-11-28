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
class SubResourceAbleTest extends TestCase
{
    public function testSubResourceSelectItems()
    {
        $query = query()->where('id', 11)
            ->where('user.age', '>', 22)
            ->where('user.status', 'ok')
            ->where('user.tags.name', 'joe')
            ->where('user.tags.key', '44')
            ->where('detail.hobby.internal', 'in', [1, 2])
            ->where('detail.index', '<=', 8)
            ->where('name', 'doe');
        $queryItems = $query->getResourceQueryItems();
        $this->assertEquals(2, count($queryItems));
        $subQueryItems = $query->getSubResourceQueryItems();
        $this->assertEquals(2, count($subQueryItems));

        $this->assertArrayHasKey('user', $subQueryItems);
        $this->assertArrayHasKey('detail', $subQueryItems);
        $this->assertArrayNotHasKey('id', $subQueryItems);
        $this->assertArrayNotHasKey('name', $subQueryItems);
        $this->assertEquals(4, count($subQueryItems['user']));
        $this->assertEquals(2, count($subQueryItems['detail']));
    }
}
