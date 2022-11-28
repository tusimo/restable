<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Query;

class QueryItem
{
    public const OPERATIONS = [
        'eq' => '=',
        'not_eq' => '!=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'in' => 'in',
        'not_in' => 'not_in',
        'between' => 'between',
        'not_between' => 'not_between',
        'like' => 'like',
        'null' => 'null',
        'not_null' => 'not_null',
    ];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $operation = '=';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * QueryItem constructor.
     * @param mixed $value
     */
    public function __construct(string $name, string $operation, $value)
    {
        $this->setName($name);
        $this->setOperation($operation);
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return static
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Check if current operation is the target operation.
     *
     * @return bool
     */
    public function isOperation(string $operation)
    {
        return $this->getOperation() === $operation;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    public function setOperation(string $operation)
    {
        foreach (static::OPERATIONS as $key => $value) {
            if ($operation == $key) {
                $this->operation = $operation;
                return;
            }
            if ($operation == $value) {
                $this->operation = $key;
                return;
            }
        }
        throw new \RuntimeException("The where operator: {$operation} is not supported");
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Detect if query item has sub query or not.
     *
     * @return bool
     */
    public function isSubQuery()
    {
        return strpos($this->getName(), '.') !== false;
    }

    /**
     * Return QueryItem array with version.
     *
     * @param string $version
     *
     * @return array
     */
    public function toArray($version = 'v2')
    {
        if ($version == 'v1') {
            return [
                $this->getName() => $this->getValueAsVersionV1String(),
            ];
        }
        return [
            $this->getName() => [
                $this->getOperation() => $this->getValueAsVersionV2String(),
            ],
        ];
    }

    /**
     * Detect if current query item isMultipleOperation.
     *
     * @param string $operation
     *
     * @return bool
     */
    public static function isMultipleOperation($operation)
    {
        return in_array($operation, [
            'in',
            'not_in',
            'between',
            'not_between',
        ]);
    }

    /**
     * Get current value as version v2 string.
     *
     * @return string
     */
    protected function getValueAsVersionV2String()
    {
        $value = $this->getValue();
        if (self::isMultipleOperation($this->getOperation())) {
            $value = implode(',', $this->getValue());
        }
        return $value ?? '';
    }

    /**
     * Get current value as version v1 string.
     *
     * @return string
     */
    protected function getValueAsVersionV1String()
    {
        if ($this->getOperation() === '>') {
            return $this->getValue() . '~';
        }
        if ($this->getOperation() === '<') {
            return '~' . $this->getValue();
        }
        if ($this->getOperation() === 'in') {
            return implode(',', $this->getValue());
        }
        if ($this->getOperation() === 'between') {
            [$first, $second] = $this->getValue();
            return $first . '~' . $second;
        }
        if ($this->getOperation() === 'like') {
            return $this->getValue() . '*';
        }
        return $this->getValue();
    }
}
