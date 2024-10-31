<?php
/**
 * TaxonomyRelation
 *
 * @author     Guido Scialfa <dev@guidoscialfa.com>
 * @package   dreamlist-framework
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

namespace QiblaDirectory\Admin\Termbox;

use QiblaDirectory\Form\Interfaces\Fields;
use QiblaDirectory\Plugin;

/**
 * Class TaxonomyRelation
 *
 * @since   1.0.0
 * @package QiblaDirectory\Admin\Termbox
 * @author     Guido Scialfa <dev@guidoscialfa.com>
 */
class TaxonomyRelation extends AbstractTermboxForm
{
    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        parent::__construct(array(
            'id'            => 'sidebar',
            'title'         => esc_html__('Sidebar', 'qibla-directory'),
            'callback'      => array($this, 'callBack'),
            'screen'        => array('amenities'),
            'context'       => 'normal',
            'priority'      => 'high',
            'callback_args' => array(),
        ));

        parent::setFields(include Plugin::getPluginDirPath('/inc/termboxFields/taxonomyRelationFields.php'));
    }
}
