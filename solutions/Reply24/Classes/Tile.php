<?php

namespace Solutions\Reply24\Classes;

class Tile
{
    public function __construct(
        public string $type,
        public Direction $direction,
        public int $cost,
        public int $count,
    ) {
    }
}
