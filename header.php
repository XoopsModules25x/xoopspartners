<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *--------------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 *--------------------------------------
 */
/**
 * XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\frontside
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */

$moduleDirName = basename(__DIR__);
require  dirname(dirname(__DIR__)) . '/mainfile.php';
xoops_load('pagenav');
if (!interface_exists('XoopspartnersConstants')) {
    require_once __DIR__ . '/class/constants.php';
}

//$helper = Helper::getHelper($moduleDirName);
$helper  = \XoopsModules\Rating\Helper::getInstance();
