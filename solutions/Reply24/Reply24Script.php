<?php

namespace Solutions\Reply24;

use Solver\Script;
use Utils\Env;
use Utils\File;

class Reply24Script extends Script
{
    public function __construct(protected Reply24Parameters $params) {}

    public function run()
    {
        $input = $this->readFile($this->params->filename);
        $parsedInput = $this->parseInput($input);
        var_dump($parsedInput);

        return json_encode([
            $this->params->filename => $parsedInput,
        ]);
    }

    private function parseInput(string $input): array
    {
        return explode("\n", $input);
    }

    private function readFile(string $filename): string
    {
        $reflector = new \ReflectionClass(static::class);
        $currentPath = explode('/', $reflector->getFileName());
        array_pop($currentPath);
        $currentPath[] = Env::INPUT_DIR;
        $currentPath[] = "{$filename}.txt";
        return File::read(join('/', $currentPath));
    }
}