<?php

namespace Woda\WordPress\AdminOptions\Utility;

final class Development
{
    private const WP_ENV_DEVELOPMENT = 'development';

    /**
     * @return bool
     */
    public static function isDevelopmentEnvironment(): bool
    {
        return defined('WP_ENV') && WP_ENV === self::WP_ENV_DEVELOPMENT;
    }
}
