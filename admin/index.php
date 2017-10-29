<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * -------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 * -------------------------------
 */
/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * @package      module\xoopspartners\admin
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 * @since        1.11
 */
use Xmf\Module\Admin;

require __DIR__ . '/admin_header.php';
$moduleAdmin = Admin::getInstance();

//-----------------------
$xpPartnersHandler = $xpHelper->getHandler('partners');

$totalPartners          = $xpPartnersHandler->getCount();
$totalNonActivePartners = $xpPartnersHandler->getCount(new Criteria('status', 0, '='));
$totalActivePartners    = $totalPartners - $totalNonActivePartners;

$moduleAdmin->addInfoBox(_MD_XOOPSPARTNERS_DASHBOARD);
$moduleAdmin->addInfoBoxLine(sprintf('<infolabel>' . _MD_XOOPSPARTNERS_TOTALACTIVE . '</infolabel>', $totalActivePartners));
$moduleAdmin->addInfoBoxLine(sprintf('<infolabel>' . _MD_XOOPSPARTNERS_TOTALNONACTIVE . '</infolabel>', $totalNonActivePartners));
$moduleAdmin->addInfoBoxLine(sprintf('<infolabel>' . _MD_XOOPSPARTNERS_TOTALPARTNERS . '</infolabel><infotext>', $totalPartners . '</infotext>'));
//----------------------------

$moduleAdmin->displayNavigation('index.php');
$moduleAdmin->displayIndex();

require __DIR__ . '/admin_footer.php';
