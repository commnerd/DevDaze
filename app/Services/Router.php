<?php

namespace App\Services;

class Router {
    public static function routed(string $url): bool
    {
        return self::isDomain($url) || self::isPath($url);
    }

    public static function isDomain(string $url): bool
    {
        return true;
    }

    public static function isPath(string $url): bool
    {
        return true;
    }
}
