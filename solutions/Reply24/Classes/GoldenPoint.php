<?php

namespace Solutions\Reply24\Classes;

class GoldenPoint extends Point
{
    public function __construct(
        public int $x,
        public int $y,
        public ?SilverPoint $nearestSilverPoint = null,
        public bool $visited = false,
    ) {
    }
}
