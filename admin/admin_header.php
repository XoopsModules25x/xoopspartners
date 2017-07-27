<?php
/*
 * XoopsPartners module
 *
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
 * @category     Module
 * @package      xoopspartners
 * @subpackage   admin
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 * @since        1.11
 */

require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include_once $GLOBALS['xoops']->path('/include/cp_functions.php');
require $GLOBALS['xoops']->path('/include/cp_header.php');

$moduleDirname = basename(dirname(__DIR__));
xoops_load('constants', $moduleDirname);

//Load languages
$moduleDirname = $GLOBALS['xoopsModule']->getVar('dirname', 'n');
xoops_loadLanguage('admin', $moduleDirname);
xoops_loadLanguage('modinfo', $moduleDirname);
xoops_loadLanguage('main', $moduleDirname);

include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');

$moduleHandler   = xoops_getHandler('module');
$moduleInfo      = $moduleHandler->get($GLOBALS['xoopsModule']->getVar('mid'));
$pathIcon16      = $GLOBALS['xoopsModule']->getInfo('icons16');
$pathIcon32      = $GLOBALS['xoopsModule']->getInfo('icons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
//$pathImageIcon  = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
//$pathImageAdmin = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');

$myts = MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    include_once $GLOBALS['xoops']->path('/class/template.php');
    $GLOBALS['xoopsTpl'] = new XoopsTpl();
}

xoops_cp_header();
