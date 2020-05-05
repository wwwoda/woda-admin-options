<?php

namespace Woda\WordPress\AdminOptions\Core;

use Carbon_Fields\Container\Theme_Options_Container;
use Woda\WordPress\AdminOptions\Settings;
use Woda\WordPress\AdminOptions\Utility\Development;
use Woda\WordPress\AdminOptions\Utility\User;

final class Container
{
    /** @var Theme_Options_Container  */
    private static $container;

    /**
     * @param string $label
     */
    public static function register(): void
    {
        if (
            Development::isDevelopmentEnvironment()
            || User::isAuthorizedAdmin()
        ) {
            self::$container = self::create();
        }
    }

    /**
     * @return Theme_Options_Container
     */
    public static function getContainer(): ?Theme_Options_Container
    {
        return self::$container;
    }

    /**
     * @return Theme_Options_Container
     */
    private static function create(): Theme_Options_Container
    {
        return \Carbon_Fields\Container::make('theme_options', Settings::getContainerLabel())
            ->set_icon(Icon::get());
    }
}
