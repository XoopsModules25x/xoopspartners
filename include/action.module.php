<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * XOOPS XoopsPartners module
 *
 * @package      module\xoopspartners\include
 * @subpackage   include
 * @author       Taiwen Jiang <phppp@users.sourceforge.net>
 * @author       zyspec <owners@zyspec.com>
 * @author       XOOPS Module Development Team
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 */

/**
 * @internal {Make sure you PROTECT THIS FILE}
 */

if ((!defined('XOOPS_ROOT_PATH'))
    || !isset($GLOBALS['xoopsUser'])
    || !($GLOBALS['xoopsUser'] instanceof XoopsUser)
    || !$GLOBALS['xoopsUser']->isAdmin()
) {
    exit('Restricted access' . PHP_EOL);
}

/**
 *
 * Prepares system prior to attempting to install module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_xoopspartners(XoopsModule $xoopsModule)
{
    if (!class_exists('XoopspartnersUtilities')) {
        xoops_load('utilities', 'xoopspartners');
    }

    //check for minimum XOOPS version
    if (!XoopspartnersUtilities::checkXoopsVer($xoopsModule)) {
        return false;
    }
    // check for minimum PHP version
    if (!XoopspartnersUtilities::checkPHPVer($xoopsModule)) {
        return false;
    }

    return true;
}

/**
 *
 * Performs tasks required during installation of the module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_xoopspartners(XoopsModule $module)
{

    $indexFile = $GLOBALS['xoops']->path('/modules/' . $module->dirname() . '/include/index.html');

    //Create the "uploads" directory for the module
    $module_uploads = $GLOBALS['xoops']->path('/uploads/' . $module->dirname());
    if (!is_dir($module_uploads)) {
        mkdir($module_uploads, 0777);
    }
    chmod($module_uploads, 0777);
    //now copy the index file to help prevent 'browsing' the directory
    copy($indexFile, $GLOBALS['xoops']->path('/uploads/' . $module->dirname() . '/index.html'));

    return true;
}

/**
 *
 * Prepares system prior to attempting to update module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if successfully ready to update module, false if not
 */
function xoops_module_pre_update_xoopspartners(XoopsModule $module)
{
    if (!class_exists('XoopspartnersUtilities')) {
        xoops_load('utilities', 'xoopspartners');
    }

    //check for minimum XOOPS version
    if (!XoopspartnersUtilities::checkXoopsVer($xoopsModule)) {
        return false;
    }
    // check for minimum PHP version
    if (!XoopspartnersUtilities::checkPHPVer($xoopsModule)) {
        return false;
    }

    return true;
}

/**
 *
 * Functions to upgrade from previous version of the module
 *
 * @param XoopsModule $module       {@link XoopsModule}
 * @param int         $curr_version version number of module currently installed
 *
 * @return bool true if successfully updated module, false if not
 */
function xoops_module_update_xoopspartners(XoopsModule $module, $curr_version = null)
{
    return true;
}

/**
 *
 * Function to perform before module uninstall
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if successfully executed, false if not
 */
function xoops_module_pre_uninstall_xoopspartners(XoopsModule $module)
{
    return true;
}

/**
 *
 * Function to complete upon module uninstall
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if successfully executed uninstall of module, false if not
 */
function xoops_module_uninstall_xoopspartners(XoopsModule $module)
{
    return true;
}
