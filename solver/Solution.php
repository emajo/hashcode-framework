<?php

namespace Solver;

use Illuminate\Support\Collection;
use Utils\ColoredString\BackgroundColor;
use Utils\ColoredString\ForegroundColor;
use Utils\DirUtils;
use Utils\Env;
use Utils\Log;
use Utils\StringUtils;

/**
 * Solution to solve a problem.
 */
class Solution {

    /**
     * Solution constructor.
     *
     * @param string $script The script class.
     * @param Collection $inputParams The collection of input Parameters.
     * @param Runner $runner The runner instance used to execute the script.
     */
    public function __construct(
        protected string $script,
        protected Collection $inputParams,
        protected Runner $runner,
        protected ?Notifier $notifier = null,
    ) {}

    /**
     * Runs the solution by executing the script with the input parameters.
     *
     * @return void
     */
    public function run(): void
    {
        $this->runner->setNotifier($this->notifier);
        $runId = 'run-' . StringUtils::random(5);
        $startTime = date('His');
        
        $this->inputParams
            ->map(fn($params) => $this->exec($params, $runId, $startTime));

        $this->onFinish($runId);
    }

    /**
     * Executes the script with the given parameters using the provided runner.
     *
     * @param mixed $params The input parameters.
     * @param string $runId The unique run ID.
     * 
     * @return void
     */
    private function exec($params, string $runId, string $startTime): void
    {
        $executionId = 'out-' . StringUtils::random(5);

        $outputDir = join('/', [
            DirUtils::getScriptDir(),
            Env::OUTPUT_DIR . $startTime . "_{$runId}",
            join('-', array_values($params->toArray())) . "_{$runId}_{$executionId}.txt"
        ]);

        $this->runner->exec($this->script, $params, "{$runId}_{$executionId}", $outputDir);
    }

    /**
     * Callback method called when the solver finishes.
     *
     * @param string $runId The ID of the current run.
     * 
     * @return void
     */
    protected function onFinish(string $runId): void
    {
        Log::out("Started {$runId}", 0, ForegroundColor::BLACK, BackgroundColor::YELLOW);
    }
}