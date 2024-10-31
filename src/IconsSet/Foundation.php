<?php
namespace QiblaDirectory\IconsSet;

/**
 * Class Fontawesome
 *
 * @since      1.0.0
 * @package    QiblaDirectory\IconsSet
 * @author     Guido Scialfa <dev@guidoscialfa.com>
 * @copyright  Copyright (c) 2018, Guido Scialfa
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2
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

/**
 * Class Foundation
 *
 * @since      1.0.0
 * @author     Guido Scialfa <dev@guidoscialfa.com>
 */
class Foundation extends AbstractIconsSet
{
    /**
     * Construct
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->version = '3';
        $this->prefix  = 'fi';
        $this->list    = array(
            'fi-address-book'          => 'f100',
            'fi-alert'                 => 'f101',
            'fi-align-center'          => 'f102',
            'fi-align-justify'         => 'f103',
            'fi-align-left'            => 'f104',
            'fi-align-right'           => 'f105',
            'fi-anchor'                => 'f106',
            'fi-annotate'              => 'f107',
            'fi-archive'               => 'f108',
            'fi-arrow-down'            => 'f109',
            'fi-arrow-left'            => 'f10a',
            'fi-arrow-right'           => 'f10b',
            'fi-arrow-up'              => 'f10c',
            'fi-arrows-compress'       => 'f10d',
            'fi-arrows-expand'         => 'f10e',
            'fi-arrows-in'             => 'f10f',
            'fi-arrows-out'            => 'f110',
            'fi-asl'                   => 'f111',
            'fi-asterisk'              => 'f112',
            'fi-at-sign'               => 'f113',
            'fi-background-color'      => 'f114',
            'fi-battery-empty'         => 'f115',
            'fi-battery-full'          => 'f116',
            'fi-battery-half'          => 'f117',
            'fi-bitcoin-circle'        => 'f118',
            'fi-bitcoin'               => 'f119',
            'fi-blind'                 => 'f11a',
            'fi-bluetooth'             => 'f11b',
            'fi-bold'                  => 'f11c',
            'fi-book-bookmark'         => 'f11d',
            'fi-book'                  => 'f11e',
            'fi-bookmark'              => 'f11f',
            'fi-braille'               => 'f120',
            'fi-burst-new'             => 'f121',
            'fi-burst-sale'            => 'f122',
            'fi-burst'                 => 'f123',
            'fi-calendar'              => 'f124',
            'fi-camera'                => 'f125',
            'fi-check'                 => 'f126',
            'fi-checkbox'              => 'f127',
            'fi-clipboard-notes'       => 'f128',
            'fi-clipboard-pencil'      => 'f129',
            'fi-clipboard'             => 'f12a',
            'fi-clock'                 => 'f12b',
            'fi-closed-caption'        => 'f12c',
            'fi-cloud'                 => 'f12d',
            'fi-comment-minus'         => 'f12e',
            'fi-comment-quotes'        => 'f12f',
            'fi-comment-video'         => 'f130',
            'fi-comment'               => 'f131',
            'fi-comments'              => 'f132',
            'fi-compass'               => 'f133',
            'fi-contrast'              => 'f134',
            'fi-credit-card'           => 'f135',
            'fi-crop'                  => 'f136',
            'fi-crown'                 => 'f137',
            'fi-css3'                  => 'f138',
            'fi-database'              => 'f139',
            'fi-die-five'              => 'f13a',
            'fi-die-four'              => 'f13b',
            'fi-die-one'               => 'f13c',
            'fi-die-six'               => 'f13d',
            'fi-die-three'             => 'f13e',
            'fi-die-two'               => 'f13f',
            'fi-dislike'               => 'f140',
            'fi-dollar-bill'           => 'f141',
            'fi-dollar'                => 'f142',
            'fi-download'              => 'f143',
            'fi-eject'                 => 'f144',
            'fi-elevator'              => 'f145',
            'fi-euro'                  => 'f146',
            'fi-eye'                   => 'f147',
            'fi-fast-forward'          => 'f148',
            'fi-female-symbol'         => 'f149',
            'fi-female'                => 'f14a',
            'fi-filter'                => 'f14b',
            'fi-first-aid'             => 'f14c',
            'fi-flag'                  => 'f14d',
            'fi-folder-add'            => 'f14e',
            'fi-folder-lock'           => 'f14f',
            'fi-folder'                => 'f150',
            'fi-foot'                  => 'f151',
            'fi-foundation'            => 'f152',
            'fi-graph-bar'             => 'f153',
            'fi-graph-horizontal'      => 'f154',
            'fi-graph-pie'             => 'f155',
            'fi-graph-trend'           => 'f156',
            'fi-guide-dog'             => 'f157',
            'fi-hearing-aid'           => 'f158',
            'fi-heart'                 => 'f159',
            'fi-home'                  => 'f15a',
            'fi-html5'                 => 'f15b',
            'fi-indent-less'           => 'f15c',
            'fi-indent-more'           => 'f15d',
            'fi-info'                  => 'f15e',
            'fi-italic'                => 'f15f',
            'fi-key'                   => 'f160',
            'fi-laptop'                => 'f161',
            'fi-layout'                => 'f162',
            'fi-lightbulb'             => 'f163',
            'fi-like'                  => 'f164',
            'fi-link'                  => 'f165',
            'fi-list-bullet'           => 'f166',
            'fi-list-number'           => 'f167',
            'fi-list-thumbnails'       => 'f168',
            'fi-list'                  => 'f169',
            'fi-lock'                  => 'f16a',
            'fi-loop'                  => 'f16b',
            'fi-magnifying-glass'      => 'f16c',
            'fi-mail'                  => 'f16d',
            'fi-male-female'           => 'f16e',
            'fi-male-symbol'           => 'f16f',
            'fi-male'                  => 'f170',
            'fi-map'                   => 'f171',
            'fi-marker'                => 'f172',
            'fi-megaphone'             => 'f173',
            'fi-microphone'            => 'f174',
            'fi-minus-circle'          => 'f175',
            'fi-minus'                 => 'f176',
            'fi-mobile-signal'         => 'f177',
            'fi-mobile'                => 'f178',
            'fi-monitor'               => 'f179',
            'fi-mountains'             => 'f17a',
            'fi-music'                 => 'f17b',
            'fi-next'                  => 'f17c',
            'fi-no-dogs'               => 'f17d',
            'fi-no-smoking'            => 'f17e',
            'fi-page-add'              => 'f17f',
            'fi-page-copy'             => 'f180',
            'fi-page-csv'              => 'f181',
            'fi-page-delete'           => 'f182',
            'fi-page-doc'              => 'f183',
            'fi-page-edit'             => 'f184',
            'fi-page-export-csv'       => 'f185',
            'fi-page-export-doc'       => 'f186',
            'fi-page-export-pdf'       => 'f187',
            'fi-page-export'           => 'f188',
            'fi-page-filled'           => 'f189',
            'fi-page-multiple'         => 'f18a',
            'fi-page-pdf'              => 'f18b',
            'fi-page-remove'           => 'f18c',
            'fi-page-search'           => 'f18d',
            'fi-page'                  => 'f18e',
            'fi-paint-bucket'          => 'f18f',
            'fi-paperclip'             => 'f190',
            'fi-pause'                 => 'f191',
            'fi-paw'                   => 'f192',
            'fi-paypal'                => 'f193',
            'fi-pencil'                => 'f194',
            'fi-photo'                 => 'f195',
            'fi-play-circle'           => 'f196',
            'fi-play-video'            => 'f197',
            'fi-play'                  => 'f198',
            'fi-plus'                  => 'f199',
            'fi-pound'                 => 'f19a',
            'fi-power'                 => 'f19b',
            'fi-previous'              => 'f19c',
            'fi-price-tag'             => 'f19d',
            'fi-pricetag-multiple'     => 'f19e',
            'fi-print'                 => 'f19f',
            'fi-prohibited'            => 'f1a0',
            'fi-projection-screen'     => 'f1a1',
            'fi-puzzle'                => 'f1a2',
            'fi-quote'                 => 'f1a3',
            'fi-record'                => 'f1a4',
            'fi-refresh'               => 'f1a5',
            'fi-results-demographics'  => 'f1a6',
            'fi-results'               => 'f1a7',
            'fi-rewind-ten'            => 'f1a8',
            'fi-rewind'                => 'f1a9',
            'fi-rss'                   => 'f1aa',
            'fi-safety-cone'           => 'f1ab',
            'fi-save'                  => 'f1ac',
            'fi-share'                 => 'f1ad',
            'fi-sheriff-badge'         => 'f1ae',
            'fi-shield'                => 'f1af',
            'fi-shopping-bag'          => 'f1b0',
            'fi-shopping-cart'         => 'f1b1',
            'fi-shuffle'               => 'f1b2',
            'fi-skull'                 => 'f1b3',
            'fi-social-500px'          => 'f1b4',
            'fi-social-adobe'          => 'f1b5',
            'fi-social-amazon'         => 'f1b6',
            'fi-social-android'        => 'f1b7',
            'fi-social-apple'          => 'f1b8',
            'fi-social-behance'        => 'f1b9',
            'fi-social-bing'           => 'f1ba',
            'fi-social-blogger'        => 'f1bb',
            'fi-social-delicious'      => 'f1bc',
            'fi-social-designer-news'  => 'f1bd',
            'fi-social-deviant-art'    => 'f1be',
            'fi-social-digg'           => 'f1bf',
            'fi-social-dribbble'       => 'f1c0',
            'fi-social-drive'          => 'f1c1',
            'fi-social-dropbox'        => 'f1c2',
            'fi-social-evernote'       => 'f1c3',
            'fi-social-facebook'       => 'f1c4',
            'fi-social-flickr'         => 'f1c5',
            'fi-social-forrst'         => 'f1c6',
            'fi-social-foursquare'     => 'f1c7',
            'fi-social-game-center'    => 'f1c8',
            'fi-social-github'         => 'f1c9',
            'fi-social-google-plus'    => 'f1ca',
            'fi-social-hacker-news'    => 'f1cb',
            'fi-social-hi5'            => 'f1cc',
            'fi-social-instagram'      => 'f1cd',
            'fi-social-joomla'         => 'f1ce',
            'fi-social-lastfm'         => 'f1cf',
            'fi-social-linkedin'       => 'f1d0',
            'fi-social-medium'         => 'f1d1',
            'fi-social-myspace'        => 'f1d2',
            'fi-social-orkut'          => 'f1d3',
            'fi-social-path'           => 'f1d4',
            'fi-social-picasa'         => 'f1d5',
            'fi-social-pinterest'      => 'f1d6',
            'fi-social-rdio'           => 'f1d7',
            'fi-social-reddit'         => 'f1d8',
            'fi-social-skillshare'     => 'f1d9',
            'fi-social-skype'          => 'f1da',
            'fi-social-smashing-mag'   => 'f1db',
            'fi-social-snapchat'       => 'f1dc',
            'fi-social-spotify'        => 'f1dd',
            'fi-social-squidoo'        => 'f1de',
            'fi-social-stack-overflow' => 'f1df',
            'fi-social-steam'          => 'f1e0',
            'fi-social-stumbleupon'    => 'f1e1',
            'fi-social-treehouse'      => 'f1e2',
            'fi-social-tumblr'         => 'f1e3',
            'fi-social-twitter'        => 'f1e4',
            'fi-social-vimeo'          => 'f1e5',
            'fi-social-windows'        => 'f1e6',
            'fi-social-xbox'           => 'f1e7',
            'fi-social-yahoo'          => 'f1e8',
            'fi-social-yelp'           => 'f1e9',
            'fi-social-youtube'        => 'f1ea',
            'fi-social-zerply'         => 'f1eb',
            'fi-social-zurb'           => 'f1ec',
            'fi-sound'                 => 'f1ed',
            'fi-star'                  => 'f1ee',
            'fi-stop'                  => 'f1ef',
            'fi-strikethrough'         => 'f1f0',
            'fi-subscript'             => 'f1f1',
            'fi-superscript'           => 'f1f2',
            'fi-tablet-landscape'      => 'f1f3',
            'fi-tablet-portrait'       => 'f1f4',
            'fi-target-two'            => 'f1f5',
            'fi-target'                => 'f1f6',
            'fi-telephone-accessible'  => 'f1f7',
            'fi-telephone'             => 'f1f8',
            'fi-text-color'            => 'f1f9',
            'fi-thumbnails'            => 'f1fa',
            'fi-ticket'                => 'f1fb',
            'fi-torso-business'        => 'f1fc',
            'fi-torso-female'          => 'f1fd',
            'fi-torso'                 => 'f1fe',
            'fi-torsos-all-female'     => 'f1ff',
            'fi-torsos-all'            => 'f200',
            'fi-torsos-female-male'    => 'f201',
            'fi-torsos-male-female'    => 'f202',
            'fi-torsos'                => 'f203',
            'fi-trash'                 => 'f204',
            'fi-trees'                 => 'f205',
            'fi-trophy'                => 'f206',
            'fi-underline'             => 'f207',
            'fi-universal-access'      => 'f208',
            'fi-unlink'                => 'f209',
            'fi-unlock'                => 'f20a',
            'fi-upload-cloud'          => 'f20b',
            'fi-upload'                => 'f20c',
            'fi-usb'                   => 'f20d',
            'fi-video'                 => 'f20e',
            'fi-volume-none'           => 'f20f',
            'fi-volume-strike'         => 'f210',
            'fi-volume'                => 'f211',
            'fi-web'                   => 'f212',
            'fi-wheelchair'            => 'f213',
            'fi-widget'                => 'f214',
            'fi-wrench'                => 'f215',
            'fi-x-circle'              => 'f216',
            'fi-x'                     => 'f217',
            'fi-yen'                   => 'f218',
            'fi-zoom-in'               => 'f219',
            'fi-zoom-out'              => 'f21a',
        );

        parent::__construct();
    }
}
