<?php

use QiblaDirectory\Functions as F;
use QiblaDirectory\Plugin;
use QiblaDirectory\Parallax;
use QiblaDirectory\Geo\LatLngFactory;
use QiblaDirectory\Request\Nonce;
use QiblaDirectory\ListingsContext\Context;

/**
 * Localized Scripts List
 *
 * @since     1.0.0
 * @author    Alfio Piccione <alfio.piccione@gmail.com>
 * @copyright Copyright (c) 2018, Alfio Piccione
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2
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

/**
 * Json Map Style
 *
 * Map styles are located in assets/json/maps-styles
 *
 * @since 1.0.0
 *
 * @param string $name The name of the json map file.
 */
$mapStyle     = apply_filters('qibla_map_style_slug', '');
$mapStylePath = $mapStyle ?
    Plugin::getPluginDirPath('/assets/json/maps-styles/' . sanitize_key($mapStyle) . '.json') :
    '';

// Try to retrieve the center of the map by a submit data.
// Default to lost serie location.
try {
    $mapCenter = LatLngFactory::createFromPostRequest(new Nonce('geocoded'));
} catch (\Exception $e) {
    $mapCenter = new QiblaDirectory\Geo\LatLng(21.4010244, -157.9784046);

    /**
     * Filter Default Map Location
     *
     * @since 1.0.0
     *
     * @param \QiblaDirectory\Geo\LatLng $mapCenter The latLng center of the map.
     */
    $mapCenter = apply_filters('qibla_directory_default_map_location', $mapCenter);
}

$list = array(
    'localized' => array(
        array(
            'handle' => is_admin() ? 'admin' : 'front',
            'name'   => 'dllocalized',
            array(
                'lang'             => get_bloginfo('language'),
                'date_format'      => get_option('date_format'),
                'time_format'      => get_option('time_format'),
                'env'              => defined('QB_ENV') ? QB_ENV : 'prod',
                'site_url'         => esc_url(site_url()),
                'usersCanRegister' => intval(get_option('users_can_register')),
                'charset'          => get_option('blog_charset') ?: 'UTF-8',
                'loggedin'         => is_user_logged_in(),
            ),
        ),
        array(
            'handle' => 'front',
            'name'   => 'dlgooglemap',
            array(
                'zoom'   => intval(F\getPluginOption('google_map', 'zoom', true)),
                'style'  => (file_exists($mapStylePath) ? file_get_contents($mapStylePath) : ''),
                'center' => $mapCenter->asAssoc(),
            ),
            function () {
                return (F\isListingsArchive() ||
                        Context::isSingleListings() ||
                        wp_script_is('dlmap-listings', 'enqueued'));
            },
        ),
        array(
            'handle' => is_admin() ? 'admin' : 'front',
            'name'   => 'dlformlocalized',
            array(
                'missedFile'    => esc_html__(
                    'Missed file. Some file that need to be send with the form is not set.',
                    'qibla-directory'
                ),
                'rejectedFiles' => esc_html__(
                    'Ops! There are some file rejected. Please check them an try again.',
                    'qibla-directory'
                ),
                'unknownError'  => esc_html__(
                    'Ops! An unknow error occurred. Please contact our support or try in a few minutes.',
                    'qibla-directory'
                ),
            ),
        ),
        array(
            'handle' => is_admin() ? 'admin' : 'front',
            'name'   => 'dlmodallocalized',
            array(
                'closeBtn'          => esc_html__('Close Modal', 'qibla-directory'),
                'signupLabel'       => sprintf(
                    esc_html__('Not a member? %s', 'qibla-directory'),
                    '<span href="#" class="u-highlight-text">' .
                    esc_html__('Sign up', 'qibla-directory') .
                    '</span>'
                ),
                'signinLabel'       => sprintf(
                    esc_html__('Returned User? %s', 'qibla-directory'),
                    '<span href="#" class="u-highlight-text">' .
                    esc_html__('Sign In', 'qibla-directory') .
                    '</span>'
                ),
                'lostPasswordLabel' => sprintf(
                    '<span href="#" class="u-highlight-text">%s</span>',
                    esc_html__('Forgot Password?', 'qibla-directory')
                ),
                'goBackLabel'       => esc_html__('Back to login', 'qibla-directory'),
            ),
        ),
        array(
            'handle' => 'front',
            'name'   => 'dlreview',
            array(
                'formLabels' => array(
                    'textAreaLabel' => esc_html__('Your Reply', 'qibla-directory'),
                    'replyTitle'    => esc_html__('Reply to %s', 'qibla-directory'),
                    'submitLabel'   => esc_html__('Send Reply', 'qibla-directory'),
                ),
            ),
        ),
    ),
);

/**
 * Filter Localized Scripts
 *
 * @since 1.0.0
 *
 * @param array $list The list of the localized scripts data
 */
return apply_filters('qibla_directory_localized_scripts_list', $list);
