<?php

namespace Woda\WordPress;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

final class AdminOptions
{
    /** @var array */
    public static $allowedEmailDomains = [];
    /** @var object */
    public static $container;
    /** @var array */
    public static $settings;

    public function init(): void
    {
        self::$allowedEmailDomains = apply_filters('woda_super_admin_allowed_email_domains', self::$allowedEmailDomains);
        self::$settings = apply_filters('woda_admin_options_settings', [
            'containerLabel' => __('Admin Options', 'woda'),
            'optionsPrefix' => 'admin_option_',
        ]);
    }

    public static function registerContainerAndFields(): void
    {
        if (self::isUserAllowedToAccess() === false) {
            return;
        }
        self::$container = self::createContainer();
        self::registerFields();
    }

    /**
     * @return Container\Theme_Options_Container
     */
    public static function getContainer(): ?Container\Theme_Options_Container
    {
        return self::$container;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function prefixOptionName(string $name): string
    {
        return self::$settings['optionsPrefix'] . $name;
    }

    /**
     * @return Container\Theme_Options_Container
     */
    private static function createContainer(): Container\Theme_Options_Container
    {
        $container = Container::make('theme_options', self::$settings['containerLabel']);
        return $container;
    }

    /**
     * @param string $email
     * @return string
     */
    private static function extractDomainFromEmail(string $email): string
    {
        if (($email = filter_var($email, FILTER_VALIDATE_EMAIL)) !== false) {
            return substr($email, strrpos($email, '@') + 1, strlen($email));
        }
        return '';
    }

    /**
     * @return bool
     */
    private static function isUserAllowedToAccess(): bool
    {
        if (empty(self::$allowedEmailDomains)) {
            return true;
        }
        $currentUser = wp_get_current_user();
        $currentUserEmail = self::extractDomainFromEmail($currentUser->user_email);
        if (in_array($currentUserEmail, self::$allowedEmailDomains, true)) {
            return true;
        }
        return false;
    }

    private static function registerFields(): void
    {
        self::$container->add_fields( array(
            Field::make('text', self::prefixOptionName('google_maps_api_key'), 'Google Maps API Key')
        ) );
    }
}
