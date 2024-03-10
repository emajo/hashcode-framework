<?php

namespace Utils;

use Utils\ColoredString\BackgroundColor;
use Utils\ColoredString\ColoredString;
use Utils\ColoredString\ForegroundColor;

class Log
{
    public static bool $verbose = true;
    public static bool $dates = true;

    public static function verbose($verbose): void
    {
        self::$verbose = $verbose;
    }

    public static function error($content): void
    {
        Log::out("ERROR: " . $content, 0, ForegroundColor::RED);
        die();
    }

    public static function out(string $content, int $level = 0, ForegroundColor $textColor = null, BackgroundColor $backgroundColor = null): void
    {
        if (self::$verbose) {
            $padding = str_repeat("   ", $level);

            if (self::$dates)
                $outputString = date("Y-m-d H:i:s") . " => ";
            else
                $outputString = '';

            $outputString .= $padding . $content;

            if ($textColor !== null || $backgroundColor !== null) {
                echo ColoredString::getColoredString($outputString, $textColor, $backgroundColor) . "\n";
            } else
                echo $outputString . "\n";
        }
    }
}
