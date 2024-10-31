<?php
/**
 * Settings Listings Fields
 *
 * @author  Alfio Piccione <alfio.piccione@gmail.com>
 *
 * @license GPL 2
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

use QiblaDirectory\Functions as F;
use QiblaDirectory\Form\Factories\FieldFactory;
use QiblaDirectory\ListingsContext\Types;

// Get the instance of the Field Factory.
$fieldFactory = new FieldFactory();

// Get Types.
$types = new Types();

/**
 * Filter Listings Settings Fields
 *
 * @since 1.0.0
 *
 * @param array $array The list of the settings fields.
 */
$fields = array(
    /**
     * Show Map
     *
     * @since 1.0.0
     */
    'qibla_opt-listings-archive_show_map:checkbox'   => $fieldFactory->table(array(
        'type'        => 'checkbox',
        'style'       => 'toggler',
        'name'        => 'qibla_opt-listings-archive_show_map',
        'value'       => F\getPluginOption('listings', 'archive_show_map', true),
        'label'       => esc_html_x('Show Map on Archive', 'settings', 'qibla-directory'),
        'description' => esc_html_x(
            'Active to show or not the map within the listings archive.',
            'settings',
            'qibla-directory'
        ),
    )),

    /**
     * Posts per Page
     *
     * @since 1.0.0
     */
    'qibla_opt-listings-posts_per_page:number'       => $fieldFactory->table(array(
        'type'        => 'number',
        'name'        => 'qibla_opt-listings-posts_per_page',
        'label'       => esc_html_x('Listings per page', 'settings', 'qibla-directory'),
        'description' => esc_html_x(
            'Enter how many listing items must be showed per page.',
            'settings',
            'qibla-directory'
        ),
        'attrs'       => array(
            'value' => F\getPluginOption('listings', 'posts_per_page', true),
            'min'   => -1,
        ),
    )),

    /**
     * Order By Featured
     *
     * @since 1.0.0
     */
    'qibla_opt-listings-order_by_featured:checkbox'  => $fieldFactory->table(array(
        'type'        => 'checkbox',
        'style'       => 'toggler',
        'name'        => 'qibla_opt-listings-order_by_featured',
        'value'       => F\getPluginOption('listings', 'order_by_featured', true),
        'label'       => esc_html_x('Featured Listings First', 'settings', 'qibla-directory'),
        'description' => esc_html_x(
            'Check if you want to show the featured listings first in archive.',
            'settings',
            'qibla-directory'
        ),
    )),

    /**
     * Disable Reviews
     *
     * @since 1.0.0
     */
    'qibla_opt-listings-disable_reviews:checkbox'    => $fieldFactory->table(array(
        'type'        => 'checkbox',
        'style'       => 'toggler',
        'name'        => 'qibla_opt-listings-disable_reviews',
        'label'       => esc_html_x('Force Disable Reviews', 'settings', 'qibla-directory'),
        'description' => esc_html_x('Force Disable reviews within single listings.', 'settings', 'qibla-directory'),
        'value'       => F\getPluginOption('listings', 'disable_reviews', true),
    )),
);

/**
 * Archive Listings Description
 *
 * @since 1.0.0
 */
foreach ($types->types() as $type) {
    $fields["qibla_opt-listings-{$type}_archive_description:wysiwyg"] = $fieldFactory->table(array(
        'type'            => 'wysiwyg',
        'name'            => "qibla_opt-listings-{$type}_archive_description",
        'label'           => sprintf(esc_html_x(
            'Archive %s Description',
            'settings',
            'qibla-directory'),
            $type),
        'description'     => sprintf(esc_html_x(
            'Type the listings %s archive description. Leave blank to not show.',
            'settings',
            'qibla-directory'
        ), $type),
        'value'           => F\getPluginOption('listings', $type . '_archive_description', true),
        'editor_settings' => array(
            'tinymce'       => true,
            'teeny'         => true,
            'media_buttons' => false,
            'quicktags'     => false,
            'textarea_rows' => 8,
            'paste_as_text' => true,
        ),
    ));
}

return apply_filters('qibla_opt_inc_listings_fields', $fields);
