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
 * @category     Module
 * @package      xoopspartners
 * @subpackage   include
 * @author       Taiwen Jiang <phppp@users.sourceforge.net>
 * @author       zyspec <owners@zyspec.com>
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */

/**
 * @internal {Make sure you PROTECT THIS FILE}
 */

if ((!defined('XOOPS_ROOT_PATH'))
    || !($GLOBALS['xoopsUser'] instanceof XoopsUser)
    || !$GLOBALS['xoopsUser']->isAdmin()
) {
    exit('Restricted access' . PHP_EOL);
}

/**
 *
 * Verifies XOOPS version meets minimum requirements for this module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if meets requirements, false if not
 */
function xoopspartnersCheckXoopsVer(XoopsModule $module)
{
    xoops_loadLanguage('admin', $module->dirname());
    //check for minimum XOOPS version
    $currentVer  = substr(XOOPS_VERSION, 6); // get the numeric part of string
    $currArray   = explode('.', $currentVer);
    $requiredVer = '' . $module->getInfo('min_xoops'); //making sure it's a string
    $reqArray    = explode('.', $requiredVer);
    $success     = true;
    foreach ($reqArray as $k => $v) {
        if (isset($currArray[$k])) {
            if ($currArray[$k] > $v) {
                break;
            } elseif ($currArray[$k] == $v) {
                continue;
            } else {
                $success = false;
                break;
            }
        } else {
            if ((int)$v > 0) { // handles things like x.x.x.0_RC2
                $success = false;
                break;
            }
        }
    }

    if (!$success) {
        $module->setErrors(sprintf(_AM_XPARTNERS_ERROR_BAD_XOOPS, $requiredVer, $currentVer));
    }

    return $success;
}

/**
 *
 * Verifies PHP version meets minimum requirements for this module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if meets requirements, false if not
 */
function xoopspartnersCheckPHPVer(XoopsModule $module)
{
    xoops_loadLanguage('admin', $module->dirname());
    // check for minimum PHP version
    $success = true;
    $verNum  = phpversion();
    $reqVer  =& $module->getInfo('min_php');
    if (false !== $reqVer && '' !== $reqVer) {
        if (version_compare($verNum, $reqVer, '<')) {
            $module->setErrors(sprintf(_AM_XPARTNERS_ERROR_BAD_XOOPS, $reqVer, $verNum));
            $success = false;
        }
    }

    return $success;
}

/**
 *
 * Prepares system prior to attempting to install module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_xoopspartners(XoopsModule $module)
{
    //check for minimum XOOPS version
    if (!xoopspartnersCheckXoopsVer($module)) {
        return false;
    }

    // check for minimum PHP version
    if (!xoopspartnersCheckPHPVer($module)) {
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
    //check for minimum XOOPS version
    if (!xoopspartnersCheckXoopsVer($module)) {
        return false;
    }

    // check for minimum PHP version
    if (!xoopspartnersCheckPHPVer($module)) {
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
