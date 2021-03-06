<?php
/*
  ------------------------------------------------------------------------
                XOOPS - PHP Content Management System
                    Copyright (c) 2000 XOOPS.org
                       <https://xoops.org>
  ------------------------------------------------------------------------
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  You may not change or alter any portion of this comment or credits
  of supporting developers from this source code or any supporting
  source code which is considered copyrighted (c) material of the
  original comment or credit authors.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 -------------------------------------------------------------------------
 Author: Raul Recio (AKA UNFOR)
 Project: The XOOPS Project
 -------------------------------------------------------------------------
 */

/**
 * XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\init
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$modversion = [
    'version'             => 2.01,
    'module_status'       => 'Beta 1',
    'release_date'        => '2020/06/20',
    'name'                => _MI_XOOPSPARTNERS_NAME,
    'description'         => _MI_XOOPSPARTNERS_DESC,
    'official'            => 0,  // 1 if maintained by XOOPS CORE Development Team
    'author'              => 'Raul Recio (unfor)',
    'credits'             => 'Mage, Mamba, ZySpec',
    'license'             => 'GNU GPL 2.0',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => $moduleDirName,
    //help files
    'helpsection' => [
        ['name' => _MI_XOOPSPARTNERS_HELP_OVERVIEW, 'link' => 'page=help',],
        ['name' => _MI_XOOPSPARTNERS_HELP_ISSUES, 'link' => 'page=issues',],
    ],
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'module_website_url'  => 'https://xoops.org',
    'module_website_name' => 'XOOPS Community',
    'min_php'             =>  '7.2',
    'min_xoops'           => '2.5.10',
    'min_db'              => ['mysql' => '5.5'],
    'min_admin'           => '1.2',
    //    'onInstall'   => 'include/action.module.php',
    //    'onUpdate'    => 'include/action.module.php',
    //    'onUninstall' => 'include/action.module.php',
    'onInstall'           => 'include/onuninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    'onUninstall'         => 'include/onuninstall.php',
    /**
     * dB settings
     */
    // All tables should not have any prefix!
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // Tables created by sql file (without prefix!)
    'tables'              => ['partners'],

    /**
     * Admin things
     */
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',

    // Set to 1 if you want to display menu generated by system module
    'system_menu'         => 1,

    /**
     * Blocks
     */
    'blocks'              => [
        [
            'file'        => 'partners.php',
            'name'        => _MI_XOOPSPARTNERS_NAME,
            'description' => _MI_XOOPSPARTNERS_DESC,
            'show_func'   => 'b_xoopspartners_show',
            'edit_func'   => 'b_xoopspartners_edit',
            'options'     => '1|1|1|1|1|hits|DESC|0',
            'template'    => 'xoopspartners_block_site.tpl',
        ],
    ],

    // Menu
    'hasMain'             => 1,

    /**
     * Templates
     */
    'templates'           => [
        [
            'file'        => 'xoopspartners_index.tpl',
            'description' => _MI_XOOPSPARTNERS_TMPLT1_DESC,
        ],

        [
            'file'        => 'xoopspartners_join.tpl',
            'description' => _MI_XOOPSPARTNERS_TMPLT2_DESC,
        ],
    ],

    // Config Settings (only for modules that need config settings generated automatically)

    // name of config option for accessing its specified value. i.e. $helper->getConfig('storyhome')
    'config'              => [
        [
            'name'        => 'cookietime',

            // title of this config option displayed in config settings form
            'title'       => '_MI_XOOPSPARTNERS_RECLICK',
            'description' => '',

            // Form element type used in config form for this option. C
            // Can be one of either textbox, textarea, select, select_multi, yesno, group, group_multi
            //
            'formtype'    => 'select',

            // value type of this config option. can be one of either int, text, float, array, or other
            // form type of 'group_multi', 'select_multi' must always be 'array'
            // form type of 'yesno', 'group' must be always be 'int'
            'valuetype'   => 'int',

            // the default value for this option
            // ignore it if no default
            // 'yesno' formtype must be either 0(no) or 1(yes)
            'default'     => 86400,
            'options'     => [
                '_MI_XOOPSPARTNERS_HOUR'    => '3600',
                '_MI_XOOPSPARTNERS_3HOURS'  => '10800',
                '_MI_XOOPSPARTNERS_5HOURS'  => '18000',
                '_MI_XOOPSPARTNERS_10HOURS' => '36000',
                '_MI_XOOPSPARTNERS_DAY'     => '86400',
            ],
        ],

        [
            'name'        => 'modlimit',
            'title'       => '_MI_XOOPSPARTNERS_MLIMIT',
            'description' => '_MI_XOOPSPARTNERS_MLIMITDSC',
            'formtype'    => 'textbox',
            'valuetype'   => 'int',
            'default'     => 5,
        ],

        [
            'name'        => 'modshow',
            'title'       => '_MI_XOOPSPARTNERS_MSHOW',
            'description' => '_MI_XOOPSPARTNERS_MSHOWDSC',
            'formtype'    => 'select',
            'valuetype'   => 'int',
            'default'     => 1,
            'options'     => [
                '_MI_XOOPSPARTNERS_IMAGES' => 1,
                '_MI_XOOPSPARTNERS_TEXT'   => 2,
                '_MI_XOOPSPARTNERS_BOTH'   => 3,
            ],
        ],

        [
            'name'        => 'modsort',
            'title'       => '_MI_XOOPSPARTNERS_MSORT',
            'description' => '_MI_XOOPSPARTNERS_MSORTDSC',
            'formtype'    => 'select',
            'valuetype'   => 'text',
            'default'     => 'hits',
            'options'     => [
                '_MI_XOOPSPARTNERS_ID'     => 'id',
                '_MI_XOOPSPARTNERS_HITS'   => 'hits',
                '_MI_XOOPSPARTNERS_TITLE'  => 'title',
                '_MI_XOOPSPARTNERS_WEIGHT' => 'weight',
            ],
        ],

        [
            'name'        => 'modorder',
            'title'       => '_MI_XOOPSPARTNERS_MORDER',
            'description' => '_MI_XOOPSPARTNERS_MORDERDSC',
            'formtype'    => 'select',
            'valuetype'   => 'text',
            'default'     => 'DESC',
            'options'     => [
                '_ASCENDING'  => 'ASC',
                '_DESCENDING' => 'DESC',
            ],
        ],

        [
            'name'        => 'incadmin',
            'title'       => '_MI_XOOPSPARTNERS_INCADMIN',
            'description' => '_MI_XOOPSPARTNERS_INCADMINDSC',
            'formtype'    => 'yesno',
            'valuetype'   => 'int',
            'default'     => 1,
        ],

        // Max Filesize Upload in kilo bytes
        [
            'name'        => 'maxuploadsize',
            'title'       => '_MI_XOOPSPARTNERS_UPLOADFILESIZE',
            'description' => '_MI_XOOPSPARTNERS_UPLOADFILESIZE_DESC',
            'formtype'    => 'textbox',
            'valuetype'   => 'int',
            'default'     => 1048576,
        ],

        // Max width
        [
            'name'        => 'maxwidth',
            'title'       => '_MI_XOOPSPARTNERS_IMAGE_MAX_WIDTH',
            'description' => '_MI_XOOPSPARTNERS_IMAGE_MAX_WIDTH_DESC',
            'formtype'    => 'textbox',
            'valuetype'   => 'int',
            'default'     => 150,
        ],

        // Max height
        [
            'name'        => 'maxheight',
            'title'       => '_MI_XOOPSPARTNERS_IMAGE_MAX_HEIGHT',
            'description' => '_MI_XOOPSPARTNERS_IMAGE_MAX_WIDTH_DESC',
            'formtype'    => 'textbox',
            'valuetype'   => 'int',
            'default'     => 110,
        ],

        /**
         * Make Sample button visible?
         */
        [
            'name'        => 'displaySampleButton',
            'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
            'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
            'formtype'    => 'yesno',
            'valuetype'   => 'int',
            'default'     => 1,
        ],

        /**
         * Show Developer Tools?
         */
        [
            'name'        => 'displayDeveloperTools',
            'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
            'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
            'formtype'    => 'yesno',
            'valuetype'   => 'int',
            'default'     => 0,
        ],
    ],
];
