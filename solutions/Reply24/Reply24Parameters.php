<?php

namespace Solutions\Reply24;

use Solver\Parameters;

class Reply24Parameters extends Parameters
{
    public function __construct(
        public ?string $filename = "",
    ) {}
}