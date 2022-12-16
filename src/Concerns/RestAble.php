<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

trait RestAble
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
    use CloneAble;
}
