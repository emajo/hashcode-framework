<?php 

namespace Solver;

/**
 * Runner Interface
 */
abstract class Runner {

    protected ?Notifier $notifier = null;

    /**
     * Sets the notifier for the Runner.
     *
     * @param Notifier $notifier The notifier to set.
     * 
     * @return void
     */
    public function setNotifier(?Notifier $notifier): void
    {
        $this->notifier = $notifier;
    }

    /**
     * Executes the given script with the provided parameters and stores the output.
     * 
     * @param string $script The script to be executed.
     * @param Parameters $params The parameters to be passed to the script.
     * @param string $uid The unique identifier for the execution.
     * @param string $outputPath The path where the output will be stored.
     * 
     * @return void
     */
    public abstract function exec(string $script, $params, string $uid, string $outputPath): void;
}