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
 * @package      module\xoopspartners\admin
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    http://xoops.org 2001-2016 &copy; XOOPS Project
 * @license      http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
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

$moduleAdmin->addInfoBox(_MD_XPARTNERS_DASHBOARD);
/*
$moduleAdmin->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, '<infolabel>' . _MD_XPARTNERS_TOTALACTIVE . '</infolabel>', $totalActivePartners, 'green');
$moduleAdmin->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, '<infolabel>' . _MD_XPARTNERS_TOTALNONACTIVE . '</infolabel>', $totalNonActivePartners, 'red');
$moduleAdmin->addInfoBoxLine(_MD_XPARTNERS_DASHBOARD, '<infolabel>' . _MD_XPARTNERS_TOTALPARTNERS . '</infolabel><infotext>', $totalPartners . '</infotext>');
*/
$moduleAdmin->addInfoBoxLine(sprintf('<infolabel>' . _MD_XPARTNERS_TOTALACTIVE . '</infolabel>', $totalActivePartners));
$moduleAdmin->addInfoBoxLine(sprintf('<infolabel>' . _MD_XPARTNERS_TOTALNONACTIVE . '</infolabel>', $totalNonActivePartners));
$moduleAdmin->addInfoBoxLine(sprintf('<infolabel>' . _MD_XPARTNERS_TOTALPARTNERS . '</infolabel><infotext>', $totalPartners . '</infotext>'));
//----------------------------

$moduleAdmin->displayNavigation('index.php');
$moduleAdmin->displayIndex();

require __DIR__ . '/admin_footer.php';
