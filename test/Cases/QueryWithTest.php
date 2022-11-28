<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Test\Cases;

use Tusimo\Query\QueryWith;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class QueryWithTest extends TestCase
{
    public function testSetWith()
    {
        $queryWith = new QueryWith(['id', 'name', 'age', null, '']);
        $this->assertEquals($queryWith->getWith(), [
            'id',
            'name',
            'age',
        ]);
    }

    public function testAppendWith()
    {
        $queryWith = new QueryWith(['id', 'name', 'age', null, '']);
        $queryWith->appendWith(['name', 'id', 'height', 'null']);
        $this->assertEquals($queryWith->getWith(), [
            'id',
            'name',
            'age',
            'height',
            'null',
        ]);
    }
}
