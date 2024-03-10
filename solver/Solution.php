<?php

namespace Solver;

use Illuminate\Support\Collection;
use Utils\DirUtils;
use Utils\Env;
use Utils\StringUtils;

/**
 * Solution to solve a problem.
 */
class Solution {

    /**
     * Solution constructor.
     *
     * @param Runner $runner The runner instance used to execute the script.
     * @param string $script The script class.
     * @param Collection $inputParams The collection of input Parameters.
     */
    public function __construct(
        private Runner $runner,
        private string $script,
        private Collection $inputParams,
    ) {}

    /**
     * Runs the solution by executing the script with the input parameters.
     *
     * @return Collection The collection of results.
     */
    public function run()
    {
        $runId = 'run-' . StringUtils::random(5);
        $res = $this->inputParams
            ->map(fn($params) => $this->exec($params, $runId));

        return $res;

    }

    /**
     * Executes the script with the given parameters using the provided runner.
     *
     * @param mixed $params The input parameters.
     * @param string $runId The unique run ID.
     * 
     * @return void
     */
    private function exec($params, string $runId): void
    {
        $executionId = 'out-' . StringUtils::random(5);

        $outputDir = join('/', [
            DirUtils::getScriptDir(),
            Env::OUTPUT_DIR . $runId,
            join('-', array_values($params->toArray())) . "_{$runId}_{$executionId}.txt"
        ]);

        $this->runner->exec($this->script, $params, "{$runId}_{$executionId}", $outputDir);
    }
}