<?php

/*------------------------------------------------------------------------
                XOOPS - PHP Content Management System
                    Copyright (c) 2000 XOOPS.org
                       <http://www.xoops.org/>
  ------------------------------------------------------------------------
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  You may not change or alter any portion of this comment or credits
  of supporting developers from this source code or any supporting
  source code which is considered copyrighted (c) material of the
  original comment or credit authors.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
  ------------------------------------------------------------------------
 Author: Raul Recio (AKA UNFOR)
 Project: The XOOPS Project
 -------------------------------------------------------------------------
 */
/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * @category     Module
 * @package      xoopspartners
 * @subpackage   admin
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 * @since        1.11
 */

require __DIR__ . '/admin_header.php';
$adminClass = new ModuleAdmin();

//-----------------------
$xpPartnerHandler = xoops_getModuleHandler('partners', $xoopsModule->getVar('dirname', 'n'));

$totalPartners          = $xpPartnerHandler->getCount();
$totalNonActivePartners = $xpPartnerHandler->getCount(new Criteria('status', 0, '='));
$totalActivePartners    = $totalPartners - $totalNonActivePartners;

$adminClass->addInfoBox(_MD_XPARTNERS_DASHBOARD);

$adminClass->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, '<infolabel>' . _MD_XPARTNERS_TOTALACTIVE . '</infolabel>', $totalActivePartners, 'Green');
$adminClass->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, '<infolabel>' . _MD_XPARTNERS_TOTALNONACTIVE . '</infolabel>', $totalNonActivePartners, 'Red');
$adminClass->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, '<infolabel>' . _MD_XPARTNERS_TOTALPARTNERS . '</infolabel><infotext>', $totalPartners . '</infotext>');
//----------------------------

echo $adminClass->addNavigation('index.php');
echo $adminClass->renderIndex();

include __DIR__ . '/admin_footer.php';
