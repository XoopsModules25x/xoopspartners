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
 * @package      module\xoopspartners\admin
 * @author       Mage, Mamba
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    http://xoops.org 2001-2016 &copy; XOOPS Project
 * @license      http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */
use Xmf\Module\Admin;

$adminmenu = array(
    array(
        'title' => _MI_XPARTNERS_ADMIN_HOME,
        'link'  => 'admin/index.php',
        'icon'  => Admin::menuIconPath('home.png')
    ),
    array(
        'title' => _MI_XPARTNERS_ADMIN_MANAGE,
        'link'  => 'admin/main.php',
        'icon'  => Admin::menuIconPath('manage.png')
    ),
    array(
        'title' => _MI_XPARTNERS_ADMIN_ADDP,
        'link'  => 'admin/main.php?op=partnersAdminAdd',
        'icon'  => Admin::menuIconPath('add.png')
    ),
    array(
        'title' => _MI_XPARTNERS_ADMIN_ABOUT,
        'link'  => 'admin/about.php',
        'icon'  => Admin::menuIconPath('about.png')
    )
);
