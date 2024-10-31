<?php
/**
 * Listings Loop Footer
 *
 * @since   1.0.0
 * @package Qibla\Views
 */

use QiblaDirectory\Functions as F;
use QiblaDirectory\Debug;

/**
 * Before Loop Footer
 *
 * @since 1.0.0
 *
 * @param \stdClass $data The data of the current object for the view.
 */
do_action('qibla_directory_before_loop_footer', $data);

if ($data->meta) : ?>

    <footer class="dlarticle__meta">
        <ul class="dlarticle__meta-list">
            <?php
            foreach ($data->meta as $key => $meta) :
                if ($meta) :
                    ob_start();
                    try {
                        // Must be sure to echo the correct data.
                        is_array($meta) && $meta = implode(', ', $meta);
                        echo esc_html($meta);
                    } catch (\Exception $e) {
                        $debugInstance = new Debug\Exception($e);
                        'dev' === QB_ENV && $debugInstance->display();

                        continue;
                    }

                    $markup = trim(ob_get_clean());
                    if ($markup) : ?>
                        <li class="dlarticle__meta-item dlarticle__meta-item--<?php echo esc_attr(sanitize_key($key)) ?>">
                            <?php echo F\ksesPost($markup); ?>
                        </li>
                        <?php
                    endif;
                endif;
            endforeach; ?>
        </ul>
    </footer>

    <?php
endif;

/**
 * After Loop Footer
 *
 * @since 1.0.0
 *
 * @param \stdClass $data The data of the current object for the view.
 */
do_action('qibla_directory_after_loop_footer', $data);
