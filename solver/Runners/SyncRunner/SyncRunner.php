<?php

namespace Solver\Runners\SyncRunner;

use Solver\Runner;
use Utils\File;
use Utils\Log;

/**
 * Synchronus runner implementation
 */
class SyncRunner implements Runner
{
    public function exec(string $script, $params, string $uid, string $outputPath): void
    {
        $result = (new $script($params))->run();
        File::write($outputPath, $result);

        Log::out("Script {$script} with id {$uid} finished");
    }
}