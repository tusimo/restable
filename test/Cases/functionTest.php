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
class functionTest extends TestCase
{
    public function testGetArrayByFirstDotElement()
    {
        $select = [
            'id',
            'name',
            'detail.id',
            'detail.name',
            'detail.user.id',
            'detail.user.age',
            'tags.id',
            'tags.name',
            'tags.user.id',
        ];
        $newArray = getArrayByFirstDotElement($select);
        $targetArray = [
            'detail' => [
                'id',
                'name',
                'user.id',
                'user.age',
            ],
            'tags' => [
                'id',
                'name',
                'user.id',
            ],
        ];
        $this->assertEquals($newArray, $targetArray);
    }
}
