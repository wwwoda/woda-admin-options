<?php

namespace Woda\WordPress\AdminOptions;

final class Initialiser
{
    /** @var string  */
    public static $optionKeyGithubAccessToken = 'woda_admin_option_github_access_token';
    /** @var string  */
    public static $optionKeyGoogleMapsKey = 'woda_admin_option_google_maps_api_key';

    public static function init(): void
    {
        add_action('admin_menu', [self::class, 'createMenu']);
    }

    public function createMenu(): void
    {
        add_menu_page(
            'Woda Admin Options',
            'Woda Admin',
            'administrator',
            __FILE__,
            [self::class, 'createMenu'],
            'dashicons-admin-network'
        );

        //call register settings function
        add_action('admin_init', [self::class, 'registerSettings']);
    }

    public function registerSettings()
    {
        register_setting('woda-admin-options', self::$optionKeyGithubAccessToken);
        register_setting('woda-admin-options', self::$optionKeyGoogleMapsKey);
    }

    public function renderSettingsPage()
    {
        ?>
            <div class="wrap">
                <h1>Woda Admin Settings</h1>
                <form method="post" action="options.php">
                    <?php settings_fields('woda-admin-options'); ?>
                    <?php do_settings_sections('woda-admin-options'); ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">GitHub Access Token</th>
                            <td><input type="password" name="<?php echo esc_attr(self::$optionKeyGithubAccessToken); ?>" value="<?php echo esc_attr(self::$optionKeyGithubAccessToken); ?>" /></td>
                        </tr>
                        <tr>
                            <th scope="row">Google Maps API Key</th>
                            <td><input type="password" name="<?php echo esc_attr(self::$optionKeyGoogleMapsKey); ?>" value="<?php echo esc_attr(self::$optionKeyGoogleMapsKey); ?>" /></td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
        <?php
    }
}
