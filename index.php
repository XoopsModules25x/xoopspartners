<?php
/*
 ------------------------------------------------------------------------
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
 ------------------------------------------------------------------------
 */
/**
 * XoopsPartners - a partner affiliation links module
 *
 * @package      module\xoopspartners\frontside
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 */
use Xmf\Request;
use Xmf\Module;

require __DIR__ . '/header.php';

$start = Request::getInt('start', 0, 'GET');

/** @var string $xoopsOption */
$xoopsOption['template_main'] = 'xoopspartners_index.tpl';
include $GLOBALS['xoops']->path('/header.php');

$xpPartnersHandler = $xpHelper->getHandler('partners');
$pathIcon16        = $xpHelper->getModule()->getInfo('icons16');
/*
$xpPartnersHandler = xoops_getModuleHandler('partners', $moduleDirname);
$moduleHandler = xoops_getHandler('module');
$moduleInfo    = $moduleHandler->get($GLOBALS['xoopsModule']->getVar('mid'));
$pathIcon16    = $GLOBALS['xoops']->url('www/' . $GLOBALS['xoopsModule']->getInfo('icons16'));
*/
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', XoopspartnersConstants::STATUS_ACTIVE, '='));
$criteria->setSort($GLOBALS['xoopsModuleConfig']['modsort']);
$criteria->setOrder($GLOBALS['xoopsModuleConfig']['modorder']);
$criteria->setLimit($GLOBALS['xoopsModuleConfig']['modlimit']);

if (0 != $xpHelper->getConfig('modlimit') && ($start > 0)) {
//if (0 != $GLOBALS['xoopsModuleConfig']['modlimit'] && ($start > 0)) {
    $criteria->setStart($start);
}

$partnerFields = array('id', 'hits', 'url', 'image', 'title', 'description');
$partnersArray = $xpPartnersHandler->getAll($criteria, $partnerFields, false, false);
$numPartners   = is_array($partnersArray) ? count($partnersArray) : 0;

$GLOBALS['xoopsTpl']->assign('partner_join', ($GLOBALS['xoopsUser'] instanceof XoopsUser) ? XoopspartnersConstants::JOIN_OK : XoopspartnersConstants::JOIN_NOT_OK);

/**
 * XOOPS Module config ['modshow']
 *    = 1   images
 *    = 2   text
 *    = 3   both
 */
$modShow = (int)$xpHelper->getConfig('modshow');
foreach ($partnersArray as $thisPartner) {
    switch ($modShow) {
//    switch ($GLOBALS['xoopsModuleConfig']['modshow']) {
        case 3: //both image and text
            if (empty($thisPartner['image'])) {
                $thisPartner['image'] = $thisPartner['title'];
            } else {
                $thisPartner['image'] = "<img src='{$thisPartner['image']}' alt='{$thisPartner['url']}' title='{$thisPartner['title']}'>" . "<br>{$thisPartner['title']}";
            }
            break;
        case 2: // text
            $thisPartner['image'] = $thisPartner['title'];
            break;
        case 1: // images
        default:
            if (empty($thisPartner['image'])) {
                $thisPartner['image'] = $thisPartner['title'];
            } else {
                $thisPartner['image'] = "<img src='{$thisPartner['image']}' alt='{$thisPartner['url']}' title='{$thisPartner['title']}'>";
            }
            break;
    }

    if (isset($GLOBALS['xoopsUser']) && $xpHelper->isUserAdmin()) {
//    if ($xoopsUserIsAdmin) {
        $thisPartner['admin_option'] =
            "<a href='admin/main.php?op=editPartner&amp;id={$thisPartner['id']}'>"
          . "<img src='{$pathIcon16}/edit.png' alt='" . _EDIT . "' title='" . _EDIT . "'></a>&nbsp;"
          . "<a href='admin/main.php?op=delPartner&amp;id={$thisPartner['id']}'>"
          . "<img src='{$pathIcon16}/delete.png' alt='" . _DELETE . "' title='" . _DELETE . "'></a>";
    }
    $GLOBALS['xoopsTpl']->append('partners', $thisPartner);
}

$modLimit = (int)$xpHelper->getConfig('modlimit');
if (0 !== $modLimit) {
    $nav     = new XoopsPageNav($numPartners, $modLimit, $start);
    $pagenav = $nav->renderImageNav();
}
$GLOBALS['xoopsTpl']->assign(array(
                                 'lang_partner'      => _MD_XPARTNERS_PARTNER,
                                 'lang_desc'         => _MD_XPARTNERS_DESCRIPTION,
                                 'lang_hits'         => _MD_XPARTNERS_HITS,
                                 'lang_no_partners'  => _MD_XPARTNERS_NOPART,
                                 'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
//                                 'sitename'          => $GLOBALS['xoopsConfig']['sitename'],
                                 'pagenav'           => $pagenav
                             ));
include_once __DIR__ . '/footer.php';
