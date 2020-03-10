<?php
/**
 * Plugin Name:       Woda Admin Options
 * Plugin URI:        https://github.com/wwwoda/woda-admin-options
 * Description:       ...
 * Version:           0.3.2
 * Author:            Woda
 * Author URI:        https://www.woda.at
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 * Text Domain:       woda-admin-options
 * GitHub Plugin URI: https://github.com/wwwoda/woda-admin-options
 * Release Asset:     true
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

include_once 'vendor/autoload.php';

$adminOptionsManager = new Manager();

add_action('after_setup_theme', static function () use ($adminOptionsManager): void {
    $adminOptionsManager->init();
    \Carbon_Fields\Carbon_Fields::boot();
} );

add_action('carbon_fields_register_fields', static function () use ($adminOptionsManager): void {
    $adminOptionsManager->registerContainerAndFields();
}, 10);
