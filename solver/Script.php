<?php

namespace Solver;

/**
 * Abstract class representing a script.
 * It provides a method for running the script.
 */
abstract class Script 
{
    /**
     * Run the script.
     *
     * @return void
     */
    public abstract function run();
}