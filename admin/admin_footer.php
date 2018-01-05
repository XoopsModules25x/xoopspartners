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
use Xmf\Module\Admin;

$moduleDirName = basename(dirname(__DIR__));
$xpHelper = Helper::getHelper($moduleDirName);
$xpModule = $xpHelper->getModule();

echo "<div class='adminfooter'>\n"
   . "<div class='center'>\n"
   .   "<a href='" . $xpModule->getInfo('author_website_url') . "' "
   .     "target='_blank'><img src='" . Admin::iconUrl('xoopsmicrobutton.gif', '32') . "' "
   .     "alt='" . $xpModule->getInfo('author_website_url') . "' "
   .     "title='" . $xpModule->getInfo('author_website_name') . "'></a>\n"
   . "</div>\n"
   . "<div class='center smallsmall italic pad5'>\n"
     . '  <strong>' . ucfirst($moduleDirName) . '</strong> ' . _AM_XOOPSPARTNERS_ADMIN_FOOTER_STR1
   . " <a class='tooltip' rel='external' href='" . $xpModule->getInfo('author_website_url') . "' "
   .      "title='" . _AM_XOOPSPARTNERS_ADMIN_FOOTER_STR2 . ' ' . $xpModule->getInfo('author_website_name') . "'>"
   .      $xpModule->getInfo('author_website_name') . "</a>\n"
   . "</div>\n"
   . "</div>\n";

xoops_cp_footer();
