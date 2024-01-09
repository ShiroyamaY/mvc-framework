<?php

namespace app\core;

class Session
{
     public const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY]  ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    public function setFlash($key,$message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    public function getFlash($key): array
    {
        if (isset($_SESSION[self::FLASH_KEY][$key])){
            return $_SESSION[self::FLASH_KEY][$key];
        }
        return [];
    }
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY];
        foreach ($flashMessages as $key => &$flashMessage){
            if ($flashMessage['remove'] === true){
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}