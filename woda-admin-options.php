<?php
/**
 * Plugin Name:       Woda Admin Options
 * Plugin URI:        https://github.com/wwwoda/wp-plugin-woda-admin-options
 * Description:       ...
 * Version:           0.2.1
 * Author:            Woda
 * Author URI:        https://www.woda.at
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 * Text Domain:       woda-admin-options
 * GitHub Plugin URI: https://github.com/wwwoda/wp-plugin-woda-admin-options
 *
 * @package           Woda_Admin_Options
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

$pluginUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/wwwoda/wp-woda-admin-options/',
    __FILE__,
    'woda-admin-options'
);

$githubAccessToken  = defined( 'GITHUB_ACCESS_TOKEN' ) ? GITHUB_ACCESS_TOKEN : get_option('woda_github_access_token');
if (!empty($githubAccessToken)) {
    $pluginUpdateChecker->setAuthentication($githubAccessToken);
}
