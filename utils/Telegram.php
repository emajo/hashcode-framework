<?php

namespace Utils;

class Telegram
{
    /**
     * Sends a message to the specified chat.
     * 
     * @param string $message The message to be sent.
     * 
     * @return void
     */
    public static function sendMessage(string $message): void
    {
        $url = 'https://api.telegram.org/bot' . static::getToken() . '/sendMessage';

        $params = [
            'chat_id' => static::getChatId(),
            'text' => $message,
        ];

        echo file_get_contents($url . '?' . static::buildQueryParams($params));
    }

    /**
     * Sends a file to a Telegram chat.
     *
     * @param string $filePath The path of the file to send.
     * @param string $caption The caption of the message.
     * 
     * @return void
     */
    public static function sendFile(string $filePath, string $caption): void
    {
        $url = 'https://api.telegram.org/bot' . static::getToken() . '/sendDocument';

        $params = [
            'chat_id' => static::getChatId(),
            'document' => new \CURLFile($filePath),
            'caption' => $caption,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:multipart/form-data']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Retrieves the Telegram bot token from the environment variables.
     *
     * @return string The Telegram bot token.
     */
    private static function getToken(): string
    {
        return Env::get('TELEGRAM_BOT_TOKEN');
    }

    /**
     * Retrieves the chat ID from the environment variables.
     * 
     * @return string The chat ID.
     */
    private static function getChatId(): string
    {
        return Env::get('TELEGRAM_CHAT_ID');
    }
    /**
     * Builds a query string from an array of parameters.
     *
     * @param array $params The parameters to be included in the query string.
     * 
     * @return string The generated query string.
     */
    private static function buildQueryParams(array $params): string
    {
        return http_build_query($params);
    }
    
}