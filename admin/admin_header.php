<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\admin
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 * @since        1.11
 */
use Xmf\Module\Helper;

require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
require $GLOBALS['xoops']->path('/include/cp_header.php');

$moduleDirName = basename(dirname(__DIR__));
$xpHelper      = Helper::getHelper($moduleDirName);

if (!interface_exists('XoopspartnersConstants')) {
    require_once $xpHelper->path('class/constants.php');
}

//Load languages
$xpHelper->loadLanguage('admin');
$xpHelper->loadLanguage('modinfo');
$xpHelper->loadLanguage('main');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    include_once $GLOBALS['xoops']->path('/class/template.php');
    $GLOBALS['xoopsTpl'] = new XoopsTpl();
}

xoops_cp_header();
