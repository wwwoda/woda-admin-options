<?php

namespace Woda\WordPress\AdminOptions\Utility;

final class User
{
    /**
     * @return bool
     */
    public static function isSuperAdmin(): bool
    {
        $superAdmins = applyFilter('woda_super_admins', []);


        $allowedEmailDomains = Settings::getAllowedEmailDomains();

        if (empty($allowedEmailDomains)) {
            return false;
        }

        $domain = self::extractDomainFromEmail(self::getCurrentUserEmail());

        if (empty($domain)) {
            return false;
        }

        if (in_array($domain, $allowedEmailDomains, true)) {
            return true;
        }

        return false;
    }

    public static function getCurrentUserEmail(): ?string
    {
        return wp_get_current_user()->data->user_email;
    }

    public static function getCurrentUserId(): ?string
    {
        return wp_get_current_user()->ID;
    }

    public static function getCurrentUserRoles(): array
    {
        $currentUser = wp_get_current_user();

        if (!is_object($currentUser) || !isset($currentUser->roles)) {
            return false;
        }

        $roles = $currentUser->roles;

        if(is_multisite() && current_user_can('setup_network')) {
            $roles[] = 'super_admin';
        }

        return $roles;
    }

    public static function getUserRoles()
    {
        $userRoles = [];
        $wpRoles = wp_roles();

        if (is_multisite()) {
            $userRoles['super_admin'] = __('Super Admin');
        }

        foreach ($wpRoles->roles as $role => $settings) {
            $userRoles[$role] = $settings['name'];
        }

        return $userRoles;
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
}
