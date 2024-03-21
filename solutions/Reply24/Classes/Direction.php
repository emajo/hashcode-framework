<?php

namespace Solutions\Reply24\Classes;

class Direction
{
    public function __construct(
        public bool $leftRight,
        public bool $rightLeft,
        public bool $leftDown,
        public bool $downLeft,
        public bool $leftUp,
        public bool $upLeft,
        public bool $upDown,
        public bool $downUp,
        public bool $upRight,
        public bool $rightUp,
        public bool $downRight,
        public bool $rightDown,
    ) {
    }
}
