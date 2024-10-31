<?php
/**
 * WordPress Directory Plugin
 *
 * @link    http://www.southemes.com
 * @package QiblaDirectory
 * @version 1.2.1
 *
 * @wordpress-plugin
 * Plugin Name: Qibla Directory
 * Plugin URI: https://southemes.com/demos/qiblaplugin/qibladirectory-free/
 * Description: The Listings Directory Plugin
 * Version: 1.2.1
 * Author: App&Map <luca@appandmap.com>
 * Author URI: http://appandmap.com/en/
 * License: GPL2
 * Text Domain: qibla-directory
 *
 * Copyright (C) 2018 Alfio Piccione <alfio.piccione@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if (! defined('QB_ENV')) {
    define('QB_ENV', 'prod');
}

if (! defined('UPX_ENV')) {
    define('UPX_ENV', 'prod');
}

// Base requirements.
require_once untrailingslashit(plugin_dir_path(__FILE__)) . '/src/Plugin.php';
require_once QiblaDirectory\Plugin::getPluginDirPath('/requires.php');
require_once QiblaDirectory\Plugin::getPluginDirPath('/src/Autoloader.php');

// Setup Auto-loader.
$loaderMap = include QiblaDirectory\Plugin::getPluginDirPath('/inc/autoloaderMapping.php');
$loader    = new \QiblaDirectory\Autoloader();

$loader->addNamespaces($loaderMap);
$loader->register();

// Register the activation hook.
register_activation_hook(__FILE__, array('QiblaDirectory\\Activate', 'activate'));
register_deactivation_hook(__FILE__, array('QiblaDirectory\\Deactivate', 'deactivate'));

add_action('plugins_loaded', function () {
    // Check Qibla Framework and Qibla Listings is active.
    if (! \QiblaDirectory\Functions\checkQiblaFramework() && ! \QiblaDirectory\Functions\checkQiblaListings()) :
        $filters = array();

        // Retrieve and build the filters based on context.
        // First common filters, than admin or front-end filters.
        // Filters include actions and filters.
        $filters = array_merge($filters, include QiblaDirectory\Plugin::getPluginDirPath('/inc/filters.php'));

        // Add filters based on context.
        if (is_admin()) {
            $filters = array_merge($filters, include QiblaDirectory\Plugin::getPluginDirPath('/inc/filtersAdmin.php'));
        } else {
            $filters = array_merge($filters, include QiblaDirectory\Plugin::getPluginDirPath('/inc/filtersFront.php'));
        }

        // Check if is an ajax request.
        // If so, include even the filters for the ajax actions.
        if (QiblaDirectory\Functions\isAjaxRequest()) {
            $filters = array_merge($filters, include QiblaDirectory\Plugin::getPluginDirPath('/inc/filtersAjax.php'));
        }

        // Let's start the game.
        $init = new QiblaDirectory\Init(new QiblaDirectory\Loader(), $filters);
        $init->init();

        // Then load the plugin text-domain.
        load_plugin_textdomain('qibla-directory', false, '/qibla-directory/languages/');

    else:
        // Disable the plugin.
        \QiblaDirectory\Functions\disablePlugin();
    endif;

    /**
     * Did Init
     *
     * @since 1.0.0
     */
    do_action('qibla_directory_did_init');
}, 20);
