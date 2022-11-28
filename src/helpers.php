<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
use Tusimo\Query\Query;

function query()
{
    return new Query();
}

/**
 * Return a array with spread array like below
 * ['user.tags', 'logs', 'account.user.tags'] => ['user', 'user.tags', 'logs', 'account', 'account.user', 'account.user.tags'].
 *
 * @return array
 */
function spreadArray(array $array)
{
    $spreadWith = [];
    foreach ($array as $data) {
        $items = explode('.', $data);
        $pre = '';
        foreach ($items as $item) {
            if ($pre == '') {
                $spreadWith[] = $item;
            } else {
                $spreadWith[] = $pre . '.' . $item;
            }
            $pre .= $item;
        }
    }
    return $spreadWith;
}

/**
 * Get all sub select resource
 * example: current select is
 * $select = [
 *   'id',
 *   'name',
 *   'detail.id',
 *   'detail.name',
 *   'detail.user.id',
 *   'detail.user.age',
 *   'tags.id',
 *   'tags.name',
 *   'tags.user.id',
 * ]
 * =>
 * return the example below
 * [
 *  'detail' => [
 *    'id',
 *    'name',
 *    'user.id',
 *    'user.age'
 *  ],
 *  'tags' => [
 *    'id',
 *    'name',
 *    'user.id'
 * ]
 * ].
 * @return array
 */
function getArrayByFirstDotElement(array $data)
{
    $items = [];
    foreach ($data as $item) {
        if (strpos($item, '.') !== false) {
            $temps = explode('.', $item);
            $key = $temps[0];
            $value = implode('.', array_slice($temps, 1));
            $items[$key][] = $value;
        }
    }
    return $items;
}
