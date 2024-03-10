<?php

namespace Utils\ColoredString;

class ColoredString
{
    // Returns colored string
    public static function getColoredString(string $string, ForegroundColor $foregoundColor = null, BackgroundColor $backgroundColor = null): string
    {
        $colored_string = "";

        // Check if given foreground color found
        if ($foregoundColor) {
            $colored_string .= "\033[" . $foregoundColor->value . "m";
        }
        // Check if given background color found
        if ($backgroundColor) {
            $colored_string .= "\033[" . $backgroundColor->value . "m";
        }

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }
}