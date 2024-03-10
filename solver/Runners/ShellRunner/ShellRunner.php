<?php

namespace Solver\Runners\ShellRunner;

use Solver\Runner;
use Utils\Env;

/**
 * Asynchronus runner implementation using shell_exec
 */
class ShellRunner implements Runner
{
    public function exec(string $script, $params, string $uid, string $outputPath): void
    {
        $reflector = new \ReflectionClass(static::class);
        $currentPath = explode('/', $reflector->getFileName());
        array_pop($currentPath);
        $currentPath[] = 'invoker.php';

        $command = [
            'php',
            implode('/', $currentPath),
            escapeshellarg($script),
            escapeshellarg(json_encode($params)),
            $uid,
            $outputPath,
        ];

        shell_exec(self::asyncronizeCommmand(join(' ', $command), $uid));
    }

    /**
     * Builds am asyncronous command to be executed.
     * Uses pm2 if available, otherwise fallbacks on nohup.
     *
     * @param string $command The command to be executed.
     * @param string $uid The unique identifier for the command.
     * 
     * @return string The command to be executed.
     */
    private static function asyncronizeCommmand(string $command, string $uid): string
    {
        $pm2 = shell_exec('which pm2');
        $asyncCommand = [];

        $escapedCommand = escapeshellarg($command);
  
        $asyncCommand = $pm2 ? [
                'pm2',
                'start',
                $escapedCommand,
                "--name={$uid}",
                '--log=' . Env::LOGS_DIR . $uid . '.log',
                '--no-autorestart',
            ] : [
                'nohup', 
                $command,
                (PHP_OS_FAMILY === "Linux" ? ">" : "&>"),
                Env::LOGS_DIR . $uid . '.log',
                '& echo $!',
            ];

        return join(' ', $asyncCommand);
    }
}