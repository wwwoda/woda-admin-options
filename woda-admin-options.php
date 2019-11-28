<?php
/**
 * Plugin Name:     Woda Admin Options
 * Plugin URI:      https://github.com/davidmondok/wp-plugin-woda-admin-options
 * Description:     ...
 * Author:          Woda
 * Author URI:      https://www.woda.at
 * Text Domain:     woda-admin-options
 * Domain Path:     /languages
 * Version:         0.1.2
 *
 * @package         Woda_Adming_options
 */

// Copyright (c) 2019 Woda Digital OG. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************

namespace Woda\WordPress\AdminOptions;

use Puc_v4_Factory;

include_once 'vendor/autoload.php';

add_action('init', static function (): void {
    $initialiser = new Initialiser();
    $initialiser->init();
});

$githubAccessToken = get_option('woda_admin_option_github_access_token');
if (!empty($githubAccessToken)) {
    $pluginUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/wwwoda/wp-woda-admin-options/',
        __FILE__,
        'woda-admin-options'
    );
    $pluginUpdateChecker->setAuthentication($githubAccessToken);
}
