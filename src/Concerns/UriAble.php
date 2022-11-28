<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query\Concerns;

use Tusimo\Query\Query;
use Tusimo\Query\QueryItem;
use Tusimo\Query\QuerySeek;
use Tusimo\Query\QueryOrderBy;
use Tusimo\Query\QueryAggregate;
use Tusimo\Query\QueryPagination;

trait UriAble
{
    /**
     * Query to uri string.
     * @version string version
     * @param mixed $version
     * @return string
     */
    public function toUriQueryString($version = 'v2')
    {
        $queries = [];
        if ($this->queryItems) {
            $queries['query'] = $this->mergeQueryItems($this->queryItems, $version);
        }
        if ($this->hasQueryWith()) {
            $queries['with'] = implode(',', $this->queryWith->getWith());
        }
        if ($this->hasQuerySelect()) {
            $queries['select'] = implode(',', $this->querySelect->getSelects());
        }
        if ($this->hasQueryOrderBy()) {
            if ($this->getQueryOrderBy()->hasOrderBy()) {
                $queries['order_by'] = $this->queryOrderBy->getOrderBy();
            }
            if ($this->getQueryOrderBy()->hasOrder()) {
                $queries['order'] = $this->queryOrderBy->getOrder();
            }
        }
        if ($this->hasQueryPagination()) {
            if ($this->getQueryPagination()->hasPage()) {
                $queries['page'] = $this->getQueryPagination()->getPage();
            }
            if ($this->getQueryPagination()->hasPerPage()) {
                $queries['per_page'] = $this->getQueryPagination()->getPerPage();
            }
        }
        if ($this->hasQueryAggregate()) {
            $result = [];
            foreach ($this->getQueryAggregate()->getAggregates() as $aggregate => $columns) {
                $result[$aggregate] = implode(',', $columns);
            }
            $queries['aggregates'] = $result;
        }
        if ($this->hasQuerySeek()) {
            if ($this->getQuerySeek()->hasOffset()) {
                $queries['offset'] = $this->getQuerySeek()->getOffset();
            }
            if ($this->getQuerySeek()->hasLimit()) {
                $queries['limit'] = $this->getQuerySeek()->getLimit();
            }
        }
        if (! empty($this->getParameters())) {
            foreach ($this->getParameters() as $key => $value) {
                $queries[$key] = $value;
            }
        }
        return http_build_query($queries);
    }

    /**
     * Undocumented function.
     *
     * @return Query
     */
    public function fromUriQueryString(string $uri)
    {
        $data = [];
        parse_str($uri, $data);
        $query = new Query();

        $query->setQueryItems($this->parseQueryItems($data['query'] ?? []));

        if (isset($data['order_by']) || isset($data['order'])) {
            $queryOrderBy = new QueryOrderBy();
            if (isset($data['order']) && $data['order'] !== '') {
                $queryOrderBy->setOrder($data['order']);
            }
            if (isset($data['order_by']) && $data['order_by'] !== '') {
                $queryOrderBy->setOrderBy($data['order_by']);
            }
            $query->setQueryOrderBy($queryOrderBy);
        }
        if (isset($data['page']) || isset($data['per_page'])) {
            $queryPagination = new QueryPagination();
            if (isset($data['page']) && $data['page'] !== '') {
                $queryPagination->setPage(intval($data['page']));
            }
            if (isset($data['per_page']) && $data['per_page'] !== '') {
                $queryPagination->setPerPage(intval($data['per_page']));
            }
            $query->setQueryPagination($queryPagination);
        }
        if (isset($data['offset']) || isset($data['limit'])) {
            $querySeek = new QuerySeek();
            if (isset($data['offset']) && $data['offset'] !== '') {
                $querySeek->setOffset(intval($data['offset']));
            }
            if (isset($data['limit']) && $data['limit'] !== '') {
                $querySeek->setLimit(intval($data['limit']));
            }
            $query->setQuerySeek($querySeek);
        }
        if (isset($data['select']) && $data['select'] !== '') {
            $query->select($this->getArray($data['select'] ?? []));
        }
        if (isset($data['with']) && $data['with'] !== '') {
            $query->with($this->getArray($data['with'] ?? []));
        }
        if (isset($data['aggregates'])) {
            $queryAggregate = new QueryAggregate();
            if (is_array($data['aggregates'])) {
                foreach ($data['aggregates'] as $aggregate => $columns) {
                    $queryAggregate->appendAggregates(
                        $aggregate,
                        $this->getArray($columns)
                    );
                }
            }
            $query->setQueryAggregate($queryAggregate);
        }
        $query->setParameters($this->parseParameters($data));
        return $query;
    }

    /**
     * Undocumented function.
     *
     * @param string $version
     *
     * @return array
     */
    protected function mergeQueryItems(array $queryItems, $version = 'v2')
    {
        $data = [];
        foreach ($queryItems as $queryItem) {
            if ($version == 'v1') {
                $data = array_merge($data, $queryItem->toArray($version));
                continue;
            }
            $data = array_merge_recursive($data, $queryItem->toArray($version));
        }
        return $data;
    }

    /**
     * Undocumented function.
     *
     * @param array $data
     *
     * @return array
     */
    protected function parseParameters($data)
    {
        $parameters = $data;
        unset(
            $parameters['query'],
            $parameters['order_by'],
            $parameters['order'],
            $parameters['page'],
            $parameters['per_page'],
            $parameters['select'],
            $parameters['with'],
            $parameters['aggregates'],
            $parameters['offset'],
            $parameters['limit']
        );

        return $parameters;
    }

    /**
     * Undocumented function.
     *
     * @return array
     */
    protected function parseQueryItems(array $queries = [])
    {
        $queryItems = [];
        foreach ($queries as $key => $query) {
            if (is_array($query)) {
                foreach ($query as $operation => $value) {
                    if (QueryItem::isMultipleOperation($operation)) {
                        $value = explode(',', $value);
                    }
                    $queryItems[] = new QueryItem($key, $operation, $value);
                }
            } else {
                $queryItems[] = $this->parseQueryItem($key, $query);
            }
        }
        return $queryItems;
    }

    /**
     * = 12
     * = 10~12 | ~13 | 14~
     * = 1,2,3
     * only support equal and range query.
     * @return QueryItem
     */
    protected function parseQueryItem(string $key, string $queryString)
    {
        if (strpos($queryString, '~') !== false) {
            [$first, $second] = explode('~', $queryString);
            if ($first !== '' && $second != '') {
                return new QueryItem($key, 'between', [$first, $second]);
            }
            if ($first !== '') {
                return new QueryItem($key, '>', $first);
            }
            if ($second !== '') {
                return new QueryItem($key, '<', $second);
            }
        }
        if (strpos($queryString, ',') != false) {
            return new QueryItem($key, 'in', explode(',', $queryString));
        }
        return new QueryItem($key, '=', $queryString);
    }

    /**
     * 根据字符获取.
     * @param array|string $item
     * @return array
     */
    protected function getArray($item)
    {
        if (is_array($item)) {
            return $item;
        }
        if (is_string($item) && $item !== '') {
            return explode(',', $item);
        }
        return [];
    }

    /**
     * Undocumented function.
     *
     * @return bool
     */
    protected function isOldVersion(array $query)
    {
        if (count($query) == count($query, 1)) {
            return true;
        }
        return false;
    }
}
