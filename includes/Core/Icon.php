<?php

namespace Woda\WordPress\AdminOptions\Core;

use Woda\WordPress\AdminOptions\Settings;

final class Icon
{
    public static function get(): string
    {
        if (self::startsWith(Settings::getContainerIcon(), '<svg')) {
            return 'data:image/svg+xml;base64,' . base64_encode(Settings::getContainerIcon());
        }
        return Settings::getContainerIcon();
    }

    private static function startsWith(string $string, string $startString): bool
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
}

