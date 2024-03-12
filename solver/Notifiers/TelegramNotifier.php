<?php

namespace Solver\Notifiers;

use Solver\Notifier;
use Utils\Telegram;

/**
 * Notifier implementation using Telegram.
 */
class TelegramNotifier implements Notifier
{
    public function pushMessage(string $message): void
    {
        Telegram::sendMessage($message);
    }

    public function pushFile(string $filePath, ?string $message): void
    {
        Telegram::sendFile($filePath, $message);
    }
}