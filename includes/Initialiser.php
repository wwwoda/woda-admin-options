<?php

namespace Woda\WordPress\AdminOptions;

final class Initialiser
{
    /** @var array  */
    public static $allowedEmailDomains = ['woda.at'];
    /** @var string  */
    public static $optionKeyGithubAccessToken = 'woda_admin_option_github_access_token';
    /** @var string  */
    public static $optionKeyGoogleMapsKey = 'woda_admin_option_google_maps_api_key';

    public function init(): void
    {
        add_action('admin_menu', [$this, 'createMenu']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    public function createMenu(): void
    {
        $currentUser = wp_get_current_user();
        /** @var array $allowedEmailDomains */
        $allowedEmailDomains = apply_filters('woda_admin_options_allowed_email_domains', self::$allowedEmailDomains);
        $currentUserEmail = explode('@', $currentUser->user_email);
        if (in_array($currentUserEmail[1], $allowedEmailDomains, true)) {
            add_menu_page(
                'Woda Admin Options',
                'Woda Admin',
                'administrator',
                __FILE__,
                [$this, 'renderSettingsPage'],
                self::getIconSvg()
            );
        }
    }

    public function registerSettings(): void
    {
        register_setting('woda-admin-options', self::$optionKeyGithubAccessToken);
        register_setting('woda-admin-options', self::$optionKeyGoogleMapsKey);
    }

    public function renderSettingsPage(): void
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
                            <td><input
                                    type="password"
                                    name="<?php echo esc_attr(self::$optionKeyGithubAccessToken); ?>"
                                    value="<?php echo esc_attr(self::$optionKeyGithubAccessToken); ?>"
                                /></td>
                        </tr>
                        <tr>
                            <th scope="row">Google Maps API Key</th>
                            <td><input
                                    type="password"
                                    name="<?php echo esc_attr(self::$optionKeyGoogleMapsKey); ?>"
                                    value="<?php echo esc_attr(self::$optionKeyGoogleMapsKey); ?>"
                                /></td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
        <?php
    }

    public static function getIconSvg($base64 = true): string
    {
        $svg = '<svg width="512" height="512" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M498.345 144h-30.253c-6.261 0-11.699 4.245-13.207 10.27l-25.409 100.368c-.731 2.83-3.199 3.149-3.93 3.149-.686 0-3.245-.091-4.113-2.921l-32.858-101.418A13.59 13.59 0 00375.596 144h-35.92a13.59 13.59 0 00-12.979 9.448l-32.903 101.464c-.914 2.784-3.382 2.921-4.113 2.921-.731 0-3.199-.319-3.93-3.149L259.839 154.27a13.635 13.635 0 00-13.207-10.224h-32.081c-4.296 0-8.226 1.962-10.831 5.34-2.605 3.377-3.428 7.713-2.331 11.867l53.377 195.807c1.6 5.888 7.038 10.042 13.162 10.042h36.788a13.591 13.591 0 0012.979-9.448l35.371-109.178c.868-2.693 3.29-2.921 3.976-2.921.731 0 3.108.228 3.976 2.921l35.097 109.132a13.59 13.59 0 0012.979 9.448h35.874c6.124 0 11.562-4.108 13.162-10.041l53.377-195.808c1.142-4.108.274-8.444-2.331-11.867-2.605-3.377-6.535-5.34-10.831-5.34zm-339.139 10.041c-1.599-5.888-7.037-10.041-13.161-10.041h-31.716c-4.295 0-8.226 1.963-10.83 5.34-2.605 3.378-3.428 7.714-2.331 11.867l53.377 195.808c1.6 5.933 7.038 10.041 13.162 10.041l31.715-.137c4.25 0 8.18-1.962 10.785-5.386 2.605-3.377 3.428-7.713 2.285-11.821l-53.286-195.671zm-100.674 0C56.932 148.153 51.494 144 45.37 144H13.655c-4.296 0-8.226 1.963-10.831 5.34-2.605 3.423-3.473 7.759-2.33 11.867L53.87 357.015c1.599 5.933 7.037 10.041 13.161 10.041l31.716-.137c4.25 0 8.18-1.962 10.785-5.386 2.604-3.377 3.427-7.713 2.285-11.821L58.532 154.041z" fill="#A0A5AA"/></svg>';
        if ($base64) {
            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        }
        return $svg;
    }
}
