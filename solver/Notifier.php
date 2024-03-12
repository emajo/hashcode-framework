<?php 

namespace Solver;

/**
 * Notifier Interface
 */
interface Notifier {
    /**
     * Pushes a message to the notification system.
     *
     * @param string $message The message to be pushed.
     * 
     * @return void
     */
    public function pushMessage(string $message): void;

    /**
     * Pushes a file to a specified path with an optional message.
     *
     * @param string $filePath The path where the file will be pushed.
     * @param string|null $message An optional message to include with the file.
     * 
     * @return void
     */
    public function pushFile(string $filePath, ?string $message): void;
}