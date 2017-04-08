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
 * @package      module\xoopspartners\frontside
 * @author       zyspec <owners@zyspec.com>
 * @author       XOOPS Module Development Team
 * @copyright    http://xoops.org 2001-2016 &copy; XOOPS Project
 * @license      http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */
use Xmf\Module\Helper;

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Module specific tpl includes
 */
if (is_object($xoTheme)) {
    $xpHelper = Helper::getHelper(basename(__DIR__));
    $xoTheme->addStylesheet($xpHelper->url('assets/css/partners.css'));
}

include_once $GLOBALS['xoops']->path('/footer.php');
