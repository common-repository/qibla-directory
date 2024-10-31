<?php
/**
 * Menu Page UsefulLinks
 *
 * @copyright Copyright (c) 2018, Angelo Marano
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2
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

namespace QiblaDirectory\Admin\Page;

use QiblaDirectory\Plugin as Plugin;
use QiblaDirectory\TemplateEngine\Engine as TEngine;

/**
 * Class UsefulLinks
 *
 * @since   1.0.0
 */
class UsefulLinks extends AbstractMenuPage
{
    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        parent::__construct(
            esc_html__('Useful Links', 'qibla-directory'),
            esc_html__('Useful Links', 'qibla-directory'),
            'qb-useful-links',
            null,
            'manage_options',
            array($this, 'callback'),
            100,
            array(),
            class_exists('\\QiblaDirectory\\Plugin') ? 'qibla-directory-options' : null
        );
    }

    /**
     * Admin bar link
     *
     * @since ${SINCE}
     *
     * @param $adminBar object The WP_Admin_Bar object
     */
    public function adminToolbar($adminBar)
    {
        if (! $adminBar instanceof \WP_Admin_Bar) {
            return;
        }

        $adminBar->add_menu(array(
            'id'     => $this->menuSlug,
            'parent' => 'qibla-directory-options',
            'title'  => $this->menuTitle,
            'href'   => esc_url(admin_url('admin.php?page=' . $this->menuSlug)),
        ));
    }

    /**
     * UsefulLinks callback
     *
     * @since  1.0.0
     *
     * @access public
     *
     * @return void
     *
     * @throws \Exception
     */
    public function callback()
    {
        $data = new \stdClass();

        $data->pageTitle         = esc_html__('Useful Links', 'qibla-directory');
        $data->documentation_url = esc_url("http://southemes.com/kb");
        $data->shop_url          = esc_url("http://appandmap.com/en/shop/");
        $data->customization_url = esc_url("mailto:support@southemes.com");
        $data->qibla2app_url     = esc_url("http://appandmap.com/en/qibla2mobile/");

        $data->documentation_bg = Plugin::getPluginDirUrl('/assets/imgs/ul_documentation.jpg');
        $data->shop_bg          = Plugin::getPluginDirUrl('/assets/imgs/ul_shop.jpg');
        $data->customization_bg = Plugin::getPluginDirUrl('/assets/imgs/ul_customization.jpg');
        $data->qibla2app_bg     = Plugin::getPluginDirUrl('/assets/imgs/ul_qibla2app.jpg');

        // View.
        $engine = new TEngine('admin_useful_links', $data, '/views/usefulLinks/adminUsefulLinks.php');
        $engine->render();
    }
}
