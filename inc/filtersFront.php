<?php
/**
 * FrontEnd Filters
 *
 * @todo      Improve the number of object created. May be put all filters within a function and create there the
 *            object?
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

use Unprefix\Scripts\ScriptsFacade;
use Unprefix\Scripts\LocalizeScripts;
use QiblaDirectory\Plugin;
use QiblaDirectory\Front;
use QiblaDirectory\LoginRegister\Register\RegisterFormFacade;
use QiblaDirectory\LoginRegister\Login\LoginFormFacade;
use QiblaDirectory\LoginRegister\LostPassword\LostPasswordFormFacade;
use QiblaDirectory\VisualComposer;
use QiblaDirectory\Review\AverageRating;
use QiblaDirectory\ListingsContext\Context;
use QiblaDirectory\ListingsContext\Types;
use QiblaDirectory\Post;

// Custom Fields Classes.
$singularHeaderMeta = new Front\CustomFields\Header();

// Scripts and Styles.
$scripts           = new ScriptsFacade(include Plugin::getPluginDirPath('/inc/scripts.php'));
$deregisterScripts = new ScriptsFacade(include Plugin::getPluginDirPath('/inc/deScriptsList.php'));

$galleryMeta      = new Front\CustomFields\Gallery();
/**
 * Filter Front Filters
 *
 * @since 1.0.0
 *
 * @param array $array The list of the filters list
 */
return apply_filters('qibla_filters_front', array(
    'front' => array(
        'action' => array(
            /**
             * Template Redirect
             *
             *  Set Last Viewed Cookie @since 1.0.0
             */
            array(
                'filter'   => 'template_redirect',
                'callback' => 'QiblaDirectory\\Functions\\setViewedCookie',
                'priority' => 20,
            ),

            /**
             * Requests
             *
             * - Search                     @since 1.0.0
             * -  Filter Request By Geocode @since 1.0.0
             */
            array(
                'filter'   => 'init',
                'callback' => 'QiblaDirectory\\Search\\Request\\RequestSearch::handleRequestFilter',
                'priority' => 10,
            ),
            array(
                'filter'   => 'init',
                'callback' => 'QiblaDirectory\\Geo\\Request\\RequestByGeocodedAddress::handleRequestFilter',
                'priority' => 20,
            ),

            /**
             * Store
             *
             * - Review @since 1.2.0
             */
            array(
                'filter'        => 'comment_post',
                'callback'      => array(
                    'QiblaDirectory\\Review\\ReviewFieldsStore',
                    'reviewFieldsStoreFilter',
                ),
                'priority'      => 20,
                'accepted_args' => 3,
            ),

            /**
             * Enqueue Scripts
             *
             * - Deregister Scripts / Style @since 1.0.0
             * - Register Scripts / Style   @since 1.0.0
             * - Lazy Localized             @since 1.0.0
             * - Enqueue Scripts / Style    @since 1.0.0
             */
            array(
                'filter'   => 'wp_enqueue_scripts',
                'callback' => array($deregisterScripts, 'deregister'),
                'priority' => 20,
            ),
            array(
                'filter'   => 'wp_enqueue_scripts',
                'callback' => array($scripts, 'register'),
                // Leave it to 20 or horrible things will happens.
                'priority' => 20,
            ),
            array(
                'filter'   => 'init',
                'callback' => function () {
                    LocalizeScripts::lazyLocalize('/inc/lazyLocalizedScriptsList.php', 'wp_enqueue_scripts');
                },
                'priority' => 20,
            ),
            array(
                'filter'   => 'init',
                'callback' => function () {
                    LocalizeScripts::lazyLocalize('/inc/localizedScriptsList.php', 'wp_enqueue_scripts');
                },
                'priority' => 20,
            ),
            array(
                'filter'   => 'wp_enqueue_scripts',
                'callback' => array($scripts, 'enqueuer'),
                'priority' => 30,
            ),

            /**
             * Pre Get Posts
             *
             * - posts per page    @since 1.0.0
             * - order by featured @since 1.0.0
             */
            array(
                'filter'   => 'pre_get_posts',
                'callback' => 'QiblaDirectory\\Front\\Settings\\Listings::postsPerPage',
                'priority' => 20,
            ),
            array(
                'filter'        => 'the_posts',
                'callback'      => 'QiblaDirectory\\Front\\Settings\\Listings::orderByFeatured',
                'priority'      => 20,
                'accepted_args' => 2,
            ),

            /**
             * Archive
             *
             * - Listings Form Filters                      @since 1.0.0
             * - Listings Toolbar                           @since 1.0.0
             * - Listings Found Posts                       @since 1.0.0
             * - Listings Archive Description               @since 1.0.0
             * - Listings Google Map                        @since 1.0.0
             */
            array(
                'filter'   => 'qibla_directory_before_archive_listings_list',
                'callback' => 'QiblaDirectory\\Filter\\Form::formFilter',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_before_archive_listings_list',
                'callback' => 'QiblaDirectory\\Functions\\listingsToolbarTmpl',
                'priority' => 30,
            ),
            array(
                'filter'   => 'qibla_directory_listings_toolbar',
                'callback' => 'QiblaDirectory\\Functions\\foundPostsTmpl',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_after_archive_listings_list',
                'callback' => 'QiblaDirectory\\Template\\ListingsArchiveFooter::template',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_after_archive_listings_list',
                'callback' => 'QiblaDirectory\\Functions\\theArchiveDescription',
                'priority' => 30,
            ),
            array(
                'filter'   => 'qibla_directory_before_archive_listings',
                'callback' => 'QiblaDirectory\\Template\\GoogleMap::template',
                'priority' => 20,
            ),

            /**
             * Loop
             *
             * - Listings Post Thumbnail Size     @since 1.0.0
             * - Listings Post Thubmnail Template @since 1.0.0
             * - Listings Post Icon               @since 1.0.0
             * - Listings Average Rating          @since 1.0.0
             * - Listings Footer Loop Location    @since 1.0.0
             */
            array(
                'filter'   => 'post_thumbnail_size',
                'callback' => 'QiblaDirectory\\Functions\\postThumbnailSize',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_loop_header',
                'callback' => 'QiblaDirectory\\Template\\Thumbnail::template',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_template_engine_data_the_post_title',
                'callback' => 'QiblaDirectory\\Functions\\listingsPostTitleIcon',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_loop_entry_content',
                'callback' => 'QiblaDirectory\\Template\\Subtitle::template',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_before_post_title',
                'callback' => function (\stdClass $data) {
                    $post  = get_post($data->ID);
                    $types = new Types();

                    if ($types->isListingsType($post->post_type) && ! Context::isSingleListings()) {
                        \QiblaDirectory\Review\AverageRating::averageRatingFilter();
                    }
                },
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_template_engine_data_post_loop_footer',
                'callback' => 'QiblaDirectory\\Functions\\listingsLoopFooterLocation',
                'priority' => 20,
            ),

            /**
             * Loop Header
             *
             * - Listings postTitle        @since 1.0.0
             */
            array(
                'filter'   => 'qibla_directory_loop_header',
                'callback' => array(new Post\Title(), 'postTitleTmpl'),
                'priority' => 20,
            ),

            /**
             * Loop Entry Content
             *
             * - Loop Listings Footer  @since 1.0.0
             */
            array(
                'filter'   => 'qibla_directory_loop_entry_content',
                'callback' => 'QiblaDirectory\\Functions\\loopFooter',
                'priority' => 20,
            ),

            /**
             * Single
             *
             * - Listings Gallery
             * - Listings Title                    @since 1.0.0
             * - Listings Terms list               @since 1.0.0
             * - Listings Sub Title                @since 1.0.0
             * - Listings Average Rating           @since 1.0.0
             * - Listings Header Subtitle          @since 1.0.0
             * - Listings Section Single Listing   @since 1.0.0
             * - Listings Review                   @since 1.0.0
             * - Listings Related Posts            @since 1.0.0
             */
            array(
                'filter'   => 'qibla_directory_single_listings_header',
                'callback' => array($galleryMeta, 'template'),
                'priority' => 10,
            ),
            array(
                'filter'   => 'qibla_directory_single_listings_header',
                'callback' => 'QiblaDirectory\\Functions\\listingsTermsListTmpl',
                // Before the single listings title.
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_single_listings_header',
                'callback' => array(new Post\Title(), 'postTitleTmpl'),
                'priority' => 30,
            ),
            array(
                'filter'   => 'qibla_directory_single_listings_header',
                'callback' => array($singularHeaderMeta, 'subtitle'),
                // After the title.
                'priority' => 40,
            ),
            array(
                'filter'   => 'qibla_directory_after_post_title',
                'callback' => function () {
                    if (Context::isSingleListings()) {
                        AverageRating::averageRatingFilter();
                    }
                },
                // After the title in theme.
                'priority' => 40,
            ),
            array(
                'filter'   => 'qibla_directory_listings_sidebar',
                'callback' => 'QiblaDirectory\\Front\\CustomFields\\ListingsLocation::listingsLocationFilter',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_listings_sidebar',
                'callback' => 'QiblaDirectory\\Template\\ShareAndWish::template',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_listings_sidebar',
                'callback' => 'QiblaDirectory\\Front\\CustomFields\\ListingsSocials::socialLinksFilter',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_after_single_listings_loop_entry_content',
                'callback' => 'QiblaDirectory\\Template\\AmenitiesTemplate::amenitiesSectionFilter',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_after_single_listings_content',
                'callback' => 'QiblaDirectory\\Front\\CustomFields\\RelatedPosts::relatedPostsFilter',
                'priority' => 40,
            ),
            array(
                'filter'   => 'qibla_directory_after_single_listings_loop',
                'callback' => 'QiblaDirectory\\Review\\ReviewList::reviewListFilter',
                'priority' => 20,
            ),

            /**
             * Single Listings
             *
             * Disable Jumbotron within the single listing package post @since 1.0.0
             */
            array(
                'filter'   => 'qibla_directory_is_jumbotron_allowed',
                'callback' => 'QiblaDirectory\\Front\\ListingPackage\\SingleListingPackage::disableJumbotronWithinSingularListingPackageFilter',
                'priority' => 20,
            ),

            /**
             * Sidebar
             *
             * Single Package Listing @since 1.0.0
             */
            array(
                'filter'   => array(
                    'qibla_directory_has_sidebar',
                    'qibla_directory_show_sidebar',
                ),
                'callback' => 'QiblaDirectory\\Sidebar::removeSidebarFromSinglePackageListingFilter',
                // After the theme and framework.
                'priority' => 40,
            ),

            /**
             * Head
             *
             * - Jumbotron customCss @since 1.0.0
             * - Jumbotron Parallax  @since 1.0.0
             * - 404 background page @since 1.0.0
             */
            array(
                'filter'   => 'wp_head',
                'callback' => array($galleryMeta, 'customCss'),
                'priority' => 20,
            ),

            /**
             * Footer
             *
             * - Listings Map Templates            @since 1.0.0
             * - Listings Togglers Templates       @since 1.0.0
             * - Listings Json Collection          @since 1.0.0
             * - Listings Form Togglers Templates  @since 1.0.0
             * - Dropzone Template                 @since 1.0.0
             * - Copyright                         @since 1.0.0
             */
            array(
                'filter'   => 'wp_footer',
                'callback' => 'QiblaDirectory\\Functions\\mapTmpls',
                // Before the scripts are loaded.
                'priority' => 10,
            ),
            array(
                'filter'   => 'wp_footer',
                'callback' => 'QiblaDirectory\\Functions\\togglersTmpls',
                // Before the scripts are loaded.
                'priority' => 10,
            ),
            array(
                'filter'   => 'wp_footer',
                'callback' => 'QiblaDirectory\\Listings\\ListingsLocalizedScript::printScriptFilter',
                'priority' => 0,
            ),
            array(
                'filter'   => 'wp_footer',
                'callback' => 'QiblaDirectory\\Shortcode\\Alert::alertAjaxTmpl',
                'priority' => 40,
            ),
            array(
                'filter'   => 'wp_footer',
                'callback' => 'QiblaDirectory\\Functions\\searchNavigationTmpl',
                'priority' => 40,
            ),
        ),
        'filter' => array(
            /**
             * Filter Wp Template for Listings Context
             *
             * This is the main hook used to load the correct template when the main context is for listings
             * post type.
             *
             * @since 1.0.0
             */
            array(
                'filter'   => 'template_include',
                'callback' => 'QiblaDirectory\\ListingsContext\\TemplateIncludeFilter::templateIncludeFilterFilter',
                'priority' => 20,
            ),

            /**
             * Fix issue with shortcode unautop
             *
             * This function must be removed after https://core.trac.wordpress.org/ticket/34722 as been fixed.
             *
             * @since 1.0.0
             */
            array(
                'filter'   => 'the_content',
                'callback' => 'DLshortcodeUnautop',
                // Must be set to 10 or will not work.
                'priority' => 10,
            ),

            /**
             * Html Scope Attributes
             *
             * - Text Only Post            @since 1.0.0
             * - Featured Listings         @since 1.0.0
             */
            array(
                'filter'        => 'qibla_scope_attribute',
                'callback'      => 'QiblaDirectory\\Functions\\getPostTextOnlyModifier',
                // Before the theme filter to able to remove it.
                'priority'      => 19,
                'accepted_args' => 5,
            ),
            array(
                'filter'        => array(
                    'qibla_scope_attribute',
                    'qibla_directory_scope_attribute',
                ),
                'callback'      => 'QiblaDirectory\\Functions\\listingsFeaturedScopeModifier',
                'priority'      => 30,
                'accepted_args' => 5,
            ),

            /**
             * Listings Data
             *
             * - Filter the listing thumbnail @since 1.0.0
             */
            array(
                'filter'   => 'qibla_directory_template_engine_data_the_post_thumbnail',
                'callback' => 'QiblaDirectory\\Functions\\postThumbToJumbotronData',
                'priority' => 20,
            ),

            /**
             * Single Comments
             *
             * - Disable Reviews Listings                @since 1.2.0
             * - Prevent Reply on Listings If not author @since 1.6.0
             * - Show Review Form                        @since 1.6.0
             */
            array(
                'filter'   => 'qibla_directory_disable_reviews',
                'callback' => 'QiblaDirectory\\Front\\Settings\\Listings::forceDisableReviews',
                'priority' => 20,
            ),
            array(
                'filter'   => 'preprocess_comment',
                'callback' => 'QiblaDirectory\\Review\\ReviewReplyCommenterCheck::checkAllowedReplyFilter',
                'priority' => 20,
            ),
            array(
                'filter'   => 'qibla_directory_after_comments',
                'callback' => 'QiblaDirectory\\Review\\ReviewForm::reviewFormFilter',
                'priority' => 20,
            ),

            /**
             * Extras
             *
             * - Body Class @since 1.0.0
             */
            array(
                'filter'   => 'body_class',
                'callback' => 'QiblaDirectory\\Functions\\bodyClass',
                'priority' => 20,
            ),

            array(
                'filter'   => 'show_admin_bar',
                'callback' => 'QiblaDirectory\\User\\DisableAdminBar::hideAdminBarFilter',
                'priority' => 20,
            ),

            /**
             * Set current lang in json search factory
             *
             * @since ${SINCE}
             */
            array(
                'filter'   => 'qibla_directory_search_json_encoder_factory',
                'callback' => function ($args) {
                    $lang = \QiblaDirectory\Functions\setCurrentLang();
                    if (\QiblaDirectory\Functions\isWpMlActive() && $lang) {
                        $args['lang'] = $lang;
                    }

                    return $args;
                },
                'priority' => 10,
            ),
        ),
    ),
));
