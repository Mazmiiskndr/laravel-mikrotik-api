<?php

namespace App\Helpers;

class ProtocolCheck
{
    public static function check(): bool
    {
        try {
            //code...
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $_SERVER['HTTPS'] = 'on';
            }
            if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
                $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
            }

            return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? true : false;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
}
