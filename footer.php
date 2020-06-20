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
 * Xoopspartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\frontside
 * @author       zyspec <zyspec@yahoo.com>
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Module specific tpl includes
 */
if (is_object($xoTheme)) {
    //    $helper = Helper::getHelper(basename(__DIR__));
    /** @var \XoopsModules\Rating\Helper $helper */
    $helper = \XoopsModules\Rating\Helper::getInstance();
    $xoTheme->addStylesheet($helper->url('assets/css/partners.css'));
}

require_once $GLOBALS['xoops']->path('/footer.php');
