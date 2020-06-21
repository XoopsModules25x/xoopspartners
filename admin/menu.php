<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *------------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 *------------------------------------
*/

/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\admin
 * @author       Mage, Mamba
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */

use Xmf\Module\Admin;
use XoopsModules\Xoopspartners;
use XoopsModules\Xoopspartners\Helper;

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';
/** @var Helper $helper */
$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}

$adminmenu = [
    [
        'title' => _MI_XOOPSPARTNERS_ADMIN_HOME,
        'link'  => 'admin/index.php',
        'icon'  => Admin::menuIconPath('home.png'),
    ],
    [
        'title' => _MI_XOOPSPARTNERS_ADMIN_MANAGE,
        'link'  => 'admin/main.php',
        'icon'  => Admin::menuIconPath('manage.png'),
    ],
    [
        'title' => _MI_XOOPSPARTNERS_ADMIN_ADDP,
        'link'  => 'admin/main.php?op=partnersAdminAdd',
        'icon'  => Admin::menuIconPath('add.png'),
    ],
    [
        'title' => _MI_XOOPSPARTNERS_ADMIN_ABOUT,
        'link'  => 'admin/about.php',
        'icon'  => Admin::menuIconPath('about.png'),
    ],
];
