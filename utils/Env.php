<?php

namespace Utils;

require_once __DIR__ . "/../env.php";


class Env
{
    public const FILES_DIR = 'files/';

    public const INPUT_DIR = self::FILES_DIR . 'input/';
    public const OUTPUT_DIR = self::FILES_DIR . 'output/';
    public const LOGS_DIR =  self::FILES_DIR . 'logs/';

    public static function get(string $key): string
    {
        return constant($key);
    }
}