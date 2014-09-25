<?php

/**
 * @param array $array
 * @param string|int $key
 * @param mixed $default
 * @return mixed
 */
function getArrayValue($array, $key, $default = null)
{
    if (!is_array($array)) {
        return $default;
    }
    return array_key_exists($key, $array) ? $array[$key] : $default;
}
