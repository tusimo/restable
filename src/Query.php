<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query;

use Tusimo\Query\Concerns\UriAble;
use Tusimo\Query\Concerns\PageAble;
use Tusimo\Query\Concerns\SeekAble;
use Tusimo\Query\Concerns\WithAble;
use Tusimo\Query\Concerns\OrderAble;
use Tusimo\Query\Concerns\QueryAble;
use Tusimo\Query\Concerns\SelectAble;
use Tusimo\Query\Concerns\AggregateAble;
use Tusimo\Query\Concerns\ParameterAble;
use Tusimo\Query\Concerns\SubResourceAble;

class Query
{
    use AggregateAble;
    use OrderAble;
    use PageAble;
    use ParameterAble;
    use QueryAble;
    use SelectAble;
    use SubResourceAble;
    use WithAble;
    use SeekAble;
    use UriAble;

    public function __clone()
    {
        foreach ($this as $key => $val) {
            if (is_object($val) || is_array($val)) {
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }
}
