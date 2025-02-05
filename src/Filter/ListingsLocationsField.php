<?php
/**
 * ListingsLocationsField
 *
 * @author     Guido Scialfa <dev@guidoscialfa.com>
 * @copyright  Copyright (c) 2018, Guido Scialfa
 * @license   GNU General Public License, version 2
 *
 * Copyright (C) 2018 Guido Scialfa <dev@guidoscialfa.com>
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

namespace QiblaDirectory\Filter;

use QiblaDirectory\Form\Factories\FieldFactory;
use QiblaDirectory\Functions as F;
use QiblaDirectory\Geo\AddressFactory;
use QiblaDirectory\Request\Nonce;

/**
 * Class ListingsLocationsField
 *
 * @since  1.0.0
 * @author     Guido Scialfa <dev@guidoscialfa.com>
 */
class ListingsLocationsField implements FilterFieldInterface
{
    /**
     * Field Name
     *
     * @since 1.0.0
     *
     * @var string The field name
     */
    private $name;

    /**
     * Field
     *
     * @since 1.0.0
     *
     * @var \QiblaDirectory\Form\Interfaces\Fields The field for internal use
     */
    private $field;

    /**
     * Geocode
     *
     * Create the geocode value from the request.
     *
     * @since 1.0.0
     *
     * @return string The address value
     */
    private static function geocode()
    {
        try {
            $geocoded = AddressFactory::createFromPostRequest(new Nonce('geocoded'));
            $geocoded = $geocoded->address();
        } catch (\Exception $e) {
            $geocoded = '';
        }

        return strtolower($geocoded);
    }

    /**
     * Retrieve value
     *
     * @since 1.0.0
     *
     * @return array|string Depending on the content may be a string or an array.
     */
    private function value()
    {
        // @codingStandardsIgnoreLine
        $value = F\filterInput($_POST, $this->name, FILTER_SANITIZE_STRING) ?: '';

        if (! $value) {
            // @codingStandardsIgnoreLine
            $value = F\filterInput($_POST, $this->name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?:
                array();
        }

        if (! $value) {
            $qObj  = get_queried_object();
            $value = $qObj instanceof \WP_Term && is_tax('locations') ? $qObj->slug : 'all';
        }

        $geocoded = self::geocode();

        if ($geocoded && 'all' === $value) {
            $value = $geocoded;
        }

        if (is_string($value)) {
            $value = strtolower($value);
        }

        return $value;
    }

    /**
     * ListingsLocationsField constructor
     *
     * @since 1.0.0
     *
     * @param string $name Name attribute for the input field.
     * @param string $type The type to use with the field.
     */
    public function __construct($name, $type)
    {
        /**
         * All Location Filter Label
         *
         * @since 1.0.0
         *
         * @param string $label The label of the filter to use as option to select all locations.
         */
        $allOptionsLabel = apply_filters(
            'qibla_listings_filter_locations_all_options_label',
            esc_html__('All Locations', 'qibla-directory')
        );

        // Select2 theme
        $selectTheme = 'on' === F\getPluginOption('general', 'disable_css', true) ? 'default' : 'qibla';

        $factory     = new FieldFactory();
        $this->name  = $name;
        $this->field = $factory->base(array(
            'type'          => $type,
            'name'          => $this->name,
            'label'         => esc_html__('Locations', 'qibla-directory'),
            'exclude_none'  => true,
            'value'         => $this->value(),
            'select2'       => true,
            'select2_theme' => $selectTheme,
            'options'       => array('all' => $allOptionsLabel) + F\getTermsList(array(
                    'taxonomy'   => 'locations',
                    'hide_empty' => false,
                )),
            'attrs'         => array(
                'class'            => 'dllistings-ajax-filter-trigger',
                'data-placeholder' => self::geocode(),
                'data-taxonomy'    => 'locations',
            ),
        ));
    }

    /**
     * @inheritdoc
     */
    public function type()
    {
        return $this->field()->getType();
    }

    /**
     * @inheritdoc
     */
    public function field()
    {
        return $this->field;
    }
}
