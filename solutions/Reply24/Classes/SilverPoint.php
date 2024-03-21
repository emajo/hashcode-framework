<?php

namespace Solutions\Reply24\Classes;

class SilverPoint extends Point
{
    public function __construct(
        public int $x,
        public int $y,
        public int $cost,
        public bool $visited = false,
        public ?SilverPoint $nearestSilverPoint = null,
    ) {
    }
}
