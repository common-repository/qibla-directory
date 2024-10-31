<?php
/**
 * Socials Fields
 *
 * @author    Alfio Piccione <alfio.piccione@gmail.com>
 * @copyright Copyright (c) 2018, Alfio Piccione
 * @license   GNU General Public License, version 2
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

use QiblaDirectory\Functions as Fw;
use QiblaDirectory\Form\Factories\FieldFactory;

$fieldFactory = new FieldFactory();
$fieldsValues = array(
    'social_facebook'    => Fw\getPostMeta('_qibla_mb_social_facebook', '', $post),
    'social_twitter'     => Fw\getPostMeta('_qibla_mb_social_twitter', '', $post),
    'social_instagram'   => Fw\getPostMeta('_qibla_mb_social_instagram', '', $post),
    'social_linkedin'    => Fw\getPostMeta('_qibla_mb_social_linkedin', '', $post),
    'social_tripadvisor' => Fw\getPostMeta('_qibla_mb_social_tripadvisor', '', $post),
);

/**
 * Listing Form Socials Fields
 *
 * @since 1.0.0
 *
 * @param array $args The list of the fields
 */
return apply_filters('qibla_listings_form_socials_fields', array(
    /**
     * Social Facebook url
     *
     * @since 1.0.0
     */
    'qibla_listing_form-meta-social_facebook:url'    => $fieldFactory->base(array(
        'type'                => 'url',
        'restriction'         => 'allow_social_facebook',
        'name'                => 'qibla_listing_form-meta-social_facebook',
        'label'               => esc_html__('Facebook', 'qibla-directory'),
        'container_class'     => array('dl-field', 'dl-field--url', 'dl-field--in-column'),
        'invalid_description' => esc_html__('Please enter valid url.', 'qibla-directory'),
        'after_input'         => function ($obj) {
            return $obj->getType()->getArg('is_invalid') ? $obj->getInvalidDescription() : '';
        },
        'attrs'               => array(
            'placeholder' => esc_html_x('http://www.facebook.com/YourFBPage', 'placeholder', 'qibla-directory'),
            'value'       => $fieldsValues['social_facebook'],
        ),
    )),

    /**
     * Social Twitter url
     *
     * @since 1.0.0
     */
    'qibla_listing_form-meta-social_twitter:url'     => $fieldFactory->base(array(
        'type'                => 'url',
        'restriction'         => 'allow_social_twitter',
        'name'                => 'qibla_listing_form-meta-social_twitter',
        'label'               => esc_html__('Twitter', 'qibla-directory'),
        'container_class'     => array('dl-field', 'dl-field--url', 'dl-field--in-column'),
        'invalid_description' => esc_html__('Please enter valid url.', 'qibla-directory'),
        'after_input'         => function ($obj) {
            return $obj->getType()->getArg('is_invalid') ? $obj->getInvalidDescription() : '';
        },
        'attrs'               => array(
            'placeholder' => esc_html_x('http://www.twitter.com/YourProfile', 'placeholder', 'qibla-directory'),
            'value'       => $fieldsValues['social_twitter'],
        ),
    )),

    /**
     * Social Instagram url
     *
     * @since 1.0.0
     */
    'qibla_listing_form-meta-social_instagram:url'   => $fieldFactory->base(array(
        'type'                => 'url',
        'restriction'         => 'allow_social_instagram',
        'name'                => 'qibla_listing_form-meta-social_instagram',
        'label'               => esc_html__('Instagram', 'qibla-directory'),
        'container_class'     => array('dl-field', 'dl-field--url', 'dl-field--in-column'),
        'invalid_description' => esc_html__('Please enter valid url.', 'qibla-directory'),
        'after_input'         => function ($obj) {
            return $obj->getType()->getArg('is_invalid') ? $obj->getInvalidDescription() : '';
        },
        'attrs'               => array(
            'placeholder' => esc_html_x('http://www.instagram.com/YourProfile', 'placeholder', 'qibla-directory'),
            'value'       => $fieldsValues['social_instagram'],
        ),
    )),

    /**
     * Social Linkedin url
     *
     * @since 1.0.0
     */
    'qibla_listing_form-meta-social_linkedin:url'    => $fieldFactory->base(array(
        'type'                => 'url',
        'restriction'         => 'allow_social_linkedin',
        'name'                => 'qibla_listing_form-meta-social_linkedin',
        'label'               => esc_html__('Linkedin', 'qibla-directory'),
        'container_class'     => array('dl-field', 'dl-field--url', 'dl-field--in-column'),
        'invalid_description' => esc_html__('Please enter valid url.', 'qibla-directory'),
        'after_input'         => function ($obj) {
            return $obj->getType()->getArg('is_invalid') ? $obj->getInvalidDescription() : '';
        },
        'attrs'               => array(
            'placeholder' => esc_html_x('http://www.linkedin.com/in/YourProfile', 'placeholder', 'qibla-directory'),
            'value'       => $fieldsValues['social_linkedin'],
        ),
    )),

    /**
     * Social Trip Advisor url
     *
     * @since 1.0.0
     */
    'qibla_listing_form-meta-social_tripadvisor:url' => $fieldFactory->base(array(
        'type'                => 'url',
        'restriction'         => 'allow_social_tripadvisor',
        'name'                => 'qibla_listing_form-meta-social_tripadvisor',
        'label'               => esc_html__('Trip Advisor', 'qibla-directory'),
        'container_class'     => array('dl-field', 'dl-field--url', 'dl-field--in-column'),
        'invalid_description' => esc_html__('Please enter valid url.', 'qibla-directory'),
        'after_input'         => function ($obj) {
            return $obj->getType()->getArg('is_invalid') ? $obj->getInvalidDescription() : '';
        },
        'attrs'               => array(
            'placeholder' => esc_html_x('http://www.tripadvisor.com/YourProfile', 'placeholder', 'qibla-directory'),
            'value'       => $fieldsValues['social_tripadvisor'],
        ),
    )),
), $fieldsValues, $post);
