<?php
/*
 * Name: footer.php
 * Description: footer for XoopsPartners
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Xoopspartners - a partner affiliation links module
 *
 * @package      module\xoopspartners\frontside
 * @author       zyspec <owners@zyspec.com>
 * @author       XOOPS Module Development Team
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Module specific tpl includes
 */
if (is_object($xoTheme)) {
    $xoTheme->addStylesheet($GLOBALS['xoops']->path('/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/assets/css/partners.css'));
    if (file_exists($GLOBALS['xoops']->path('/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/css/module.css'))) {
        $xoTheme->addStylesheet($GLOBALS['xoops']->path('/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/css/module.css'));
    }
}

include_once $GLOBALS['xoops']->path('/footer.php');
