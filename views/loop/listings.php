<?php
/**
 * Main Loop
 *
 * @author    Alfio Piccione <alfio.piccione@gmail.com>
 * @package   dreamlist-framework
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

use QiblaDirectory\Functions as F;

// The post.
$post = get_post();

/**
 * Before Post
 *
 * @since 1.0.0
 */
do_action('qibla_directory_before_listings_loop'); ?>

<article id="post-<?php the_ID() ?>"
    <?php post_class(F\getScopeClass('article', '', array('listings', 'overlay', 'card'))) ?>
         data-marker="<?php echo esc_html($post->post_name) ?>">

    <div <?php F\scopeClass('article-card-box') ?>>
        <?php
        /**
         * Before Loop Header
         *
         * @since 1.0.0
         * @since 1.0.0 Introduce $post parameter
         *
         * @param \WP_Post The current post.
         */
        do_action('qibla_directory_before_listings_loop_header', $post); ?>

        <header <?php F\scopeClass('article', 'header') ?>>

            <a <?php F\scopeClass('article', 'link') ?> href="<?php echo esc_url(get_permalink()) ?>">
                <?php
                /**
                 * Loop Header
                 *
                 * @since 1.0.0
                 * @since 1.0.0 Introduce $post parameter
                 *
                 * @param \WP_Post The current post.
                 */
                do_action('qibla_directory_loop_header', $post); ?>
            </a>

        </header>

        <a <?php F\scopeClass('article', 'link') ?> href="<?php echo esc_url(get_permalink()) ?>">
            <?php
            /**
             * Loop entry Content
             *
             * @since 1.0.0
             * @since 1.0.0 Introduce $post parameter
             *
             * @param \WP_Post The current post.
             */
            do_action('qibla_directory_loop_entry_content', $post); ?>
        </a>
    </div>
</article>

<?php
/**
 * After Post
 *
 * @since 1.0.0
 * @since 1.0.0 Introduce $post parameter
 *
 * @param \WP_Post The current post.
 */
do_action('qibla_directory_after_listings_loop', $post); ?>
