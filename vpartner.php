<?php
/*
 -----------------------------------------------------------------------
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
 -------------------------------------------------------------------------
 Author: Raul Recio (AKA UNFOR)
 Project: The XOOPS Project
 -------------------------------------------------------------------------
 */
/**
 * XoopsPartners - a partner affiliation links module
 *
 * @category     Module
 * @package      xoopspartners
 * @subpackage   front
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 */

include __DIR__ . '/header.php';
$xpPartnerHandler = xoops_getModuleHandler('partners', $moduleDirname);

$id = XoopsRequest::getInt('id', XoopspartnersConstants::DEFAULT_PID, 'GET');
if (XoopspartnersConstants::DEFAULT_PID == $id) {
    redirect_header('index.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _MD_XPARTNERS_NOPART);
}

$partnerObj = $xpPartnerHandler->get($id);
if (($partnerObj instanceof XoopspartnersPartners) && $partnerObj->getVar('url') && (XoopspartnersConstants::STATUS_ACTIVE == $partnerObj->getVar('status'))) {
    $modMid = ($GLOBALS['xoopsModule'] instanceof XoopsModule) ? $GLOBALS['xoopsModule']->getVar('mid') : XoopspartnersConstants::DEFAULT_MID;
    if (!($GLOBALS['xoopsUser'] instanceof XoopsUser) || !$GLOBALS['xoopsUser']->isAdmin($modMid) || !$GLOBALS['xoopsModule']->getInfo('incadmin')) {
        if (!isset($_COOKIE['partners'][$id])) {
            setcookie("partners[{$id}]", $id, $GLOBALS['xoopsModuleConfig']['cookietime']);
            $hitCount = $partnerObj->getVar('hits');
            ++$hitCount;
            $partnerObj->setVar('hits', $hitCount);
            $xpPartnerHandler->insert($partnerObj);
        }
    }
    echo "<html>\n" . "  <head>\n" . "    <meta http-equiv='Refresh' content='0; URL=" . htmlentities($partnerObj->getVar('url')) . "'>\n" . "  </head>\n" . "  <body></body>\n" . "</html>\n";
} else {
    unset($xpPartnerHandler);
    redirect_header('index.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _MD_XPARTNERS_NOPART);
}
