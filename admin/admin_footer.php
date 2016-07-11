<?php
/*
 * XoopsPartner module
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
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 * @since        1.11
 */

if (!isset($moduleInfo) || !is_a($moduleInfo, 'XoopsModule')) {
    $moduleHandler = xoops_getHandler('module');
    $xoopsModule    = XoopsModule::getByDirname('mylinks');
    $moduleInfo     = $moduleHandler->get($xoopsModule->getVar('mid'));
    $pathIcon32     = $moduleInfo->getInfo('icons32');
}

echo "<div class='adminfooter'>\n" . "  <div class='txtcenter'>\n" . "    <a href='" . $moduleInfo->getInfo('author_website_url') . "' target='_blank'><img src='" . $GLOBALS['xoops']->url("www/{$pathIcon32}/xoopsmicrobutton.gif") . "' alt='" . $xoopsModule->getInfo('author_website_name')
     . "' title='" . $moduleInfo->getInfo('author_website_name') . "'></a>\n" . "  </div>\n" . '  ' . _AM_XPARTNERS_ADMIN_FOOTER . "\n" . "</div>\n";

xoops_cp_footer();