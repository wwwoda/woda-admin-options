<?php

namespace Woda\WordPress\AdminOptions;

/**
 * Class Settings
 * @package Woda\WordPress\ACF
 */
final class Init
{
    public static function init(array $settings = []): void
    {
        add_action('after_setup_theme', static function () use ($settings): void {
            Settings::init($settings);
            \Carbon_Fields\Carbon_Fields::boot();
        } );

        add_action('carbon_fields_register_fields', static function (): void {
            Core\Container::register();
        }, 10);
    }
}
