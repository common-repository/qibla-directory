<?php
use QiblaDirectory\Functions as F;

/**
 * View pagination
 *
 * @since   1.0.0
 * @package Qibla\Views
 */

if ($data->pagination) : ?>
    <nav <?php F\scopeClass('pagination', '', 'post-paged') ?>>
        <p class="screen-reader-text"><?php esc_html_e('Pages:', 'qibla-directory') ?></p>
        <?php echo F\ksesPost($data->pagination) ?>
    </nav>
<?php endif; ?>