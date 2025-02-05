<?php
/**
 * View Related Posts
 *
 * @since 1.0.0
 *
 * Copyright (C) 2018 Alfio Piccione
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
?>

<?php if ($data->relatedPosts) : ?>
    <div class="dlrelated-posts">
        <?php
        if ('post' === get_post_type()) : ?>
            <h2 class="dlrelated-posts__title">
                <?php esc_html_e('Related Posts', 'qibla-directory') ?>
            </h2>
        <?php endif; ?>

        <div class="dlcontainer">
            <?php
            // @codingStandardsIgnoreLine
            echo F\ksesPost($data->relatedPosts); ?>
        </div>
    </div>
<?php endif; ?>
