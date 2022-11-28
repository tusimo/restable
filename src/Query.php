<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable;

use Tusimo\Restable\Concerns\UriAble;
use Tusimo\Restable\Concerns\PageAble;
use Tusimo\Restable\Concerns\SeekAble;
use Tusimo\Restable\Concerns\WithAble;
use Tusimo\Restable\Concerns\OrderAble;
use Tusimo\Restable\Concerns\QueryAble;
use Tusimo\Restable\Concerns\SelectAble;
use Tusimo\Restable\Concerns\AggregateAble;
use Tusimo\Restable\Concerns\ParameterAble;
use Tusimo\Restable\Concerns\SubResourceAble;

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
