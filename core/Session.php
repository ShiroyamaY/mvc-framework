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
    public function set($key,$value): void
    {
        $_SESSION[$key] = $value;
    }
    public function get($key){
        return $_SESSION[$key] ?? false;
    }
    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }
    public function setFlash($key,$message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    public function getFlash($keyArray): array
    {
        foreach ($keyArray as $key){
            if (isset($_SESSION[self::FLASH_KEY][$key])){
                return $_SESSION[self::FLASH_KEY][$key];
            }
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