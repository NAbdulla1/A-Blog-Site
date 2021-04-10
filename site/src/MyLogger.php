<?php


namespace Blog;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MyLogger
{
    private static $logger = null;

    private function __construct()
    {
    }

    public static function dbg($message)
    {
        if (self::$logger == null) {
            self::$logger = new Logger('debug-channel');
            self::$logger->pushHandler(new StreamHandler(__DIR__ . "/../../logs.log", Logger::DEBUG));
        }
        self::$logger->debug($message);
    }
}