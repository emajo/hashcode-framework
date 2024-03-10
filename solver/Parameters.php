<?php

namespace Solver;

/**
 * Abstract class representing a set of parameters used by a Script.
 */
abstract class Parameters
{
    /**
     * Creates a new instance of the parameters class from an array.
     *
     * @param array $array The array containing the parameter values.
     * 
     * @return static The new instance of the parameters class.
     */
    public static function fromArray(array $array): static
    {
        $params = new static();
        foreach($array as $param => $value) {
            $params->{$param} = $value;
        }

        return $params;
    }

    /**
     * Creates a new instance of the parameters class from a JSON string.
     *
     * @param string $json The JSON string containing the parameter values.
     * 
     * @return static The new instance of the parameters class.
     */
    public static function fromJson(string $json): static
    {
        return static::fromArray(json_decode($json, true));
    }

    /**
     * Converts the parameters object to an array.
     *
     * @return array The array representation of the parameters object.
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}