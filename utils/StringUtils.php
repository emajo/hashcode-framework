<?php

namespace Utils;

class StringUtils
{
    /**
     * Generates a random string of specified length.
     *
     * @param int $length The length of the random string to generate.
     * 
     * @return string The randomly generated string.
     */
    public static function random(int $length)
    {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
    }
}