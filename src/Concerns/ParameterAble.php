<?php

declare(strict_types=1);
/**
 * This file is part of API Service.
 *
 * Please follow the code rules : PSR-2
 */
namespace Tusimo\Restable\Concerns;

trait ParameterAble
{
    /**
     * Extra Parameter for query.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Add a parameters.
     *
     * @return static
     */
    public function withParameter(string $key, string $parameter)
    {
        $this->parameters[$key] = $parameter;
        return $this;
    }

    /**
     * Check if has a parameter.
     *
     * @return bool
     */
    public function hasParameter(string $key)
    {
        return isset($this->parameters[$key]);
    }

    /**
     * Get a specific parameter with key.
     *
     * @param mixed $default
     */
    public function getParameter(string $key, $default = null)
    {
        return $this->parameters[$key] ?? $default;
    }

    /**
     * Set Parameters.
     *
     * @return static
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Get All Parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Add Parameters.
     *
     * @return static
     */
    public function parameter(string $key, string $parameter)
    {
        return $this->withParameter($key, $parameter);
    }
}
