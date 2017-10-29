<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *--------------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 *--------------------------------------
 */
/**
 * XoopsPartners - a partner affiliation links module
 *
 * @package      module\xoopspartners\frontside
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */
use Xmf\Request;
use Xmf\Module;
use Xmf\Module\Admin;

require __DIR__ . '/header.php';

$start = Request::getInt('start', 0, 'GET');

/** @var string $xoopsOption */
$xoopsOption['template_main'] = 'xoopspartners_index.tpl';
include $GLOBALS['xoops']->path('/header.php');

$xpPartnersHandler = $xpHelper->getHandler('partners');
$modConfigs        = $xpHelper->getConfig();

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', XoopspartnersConstants::STATUS_ACTIVE, '='));
$criteria->setSort($modConfigs['modsort']);
$criteria->setOrder($modConfigs['modorder']);
$criteria->setLimit($modConfigs['modlimit']);

if (!empty($modConfigs['modlimit']) && ($start > 0)) {
    $criteria->setStart($start);
}

$partnerFields = array('id', 'hits', 'url', 'image', 'title', 'description');
$partnersArray = $xpPartnersHandler->getAll($criteria, $partnerFields, false, false);
$numPartners   = is_array($partnersArray) ? count($partnersArray) : 0;

$GLOBALS['xoopsTpl']->assign('partner_join',
                        ($GLOBALS['xoopsUser'] instanceof XoopsUser)
                        ? XoopspartnersConstants::JOIN_OK
                        : XoopspartnersConstants::JOIN_NOT_OK
);

/**
 * XOOPS Module config ['modshow']
 *    = 1   images (binary 01)
 *    = 2   text   (binary 10)
 *    = 3   both   (binary 11)
 */
$modShow = (int)$modConfigs['modshow'];
foreach ($partnersArray as $thisPartner) {
    if ($modShow & XoopspartnersConstants::SHOW_IMAGE) { // want image
        if (empty($thisPartner['image'])) { //but there isn't one
                $thisPartner['image'] = $thisPartner['title'];
            } else {
            $thisPartner['image'] =
            "<img src='{$thisPartner['image']}' "
            .   "alt='{$thisPartner['url']}' "
            .   "title='{$thisPartner['title']}'>";
            }
            } else {
        $thisPartner['image'] = '';
            }
    if ((($modShow & XoopspartnersConstants::SHOW_TITLE) // want text or invalid setting
        || (0 === ($modShow & (XoopspartnersConstants::SHOW_TITLE && XoopspartnersConstants::SHOW_IMAGE))))
        && ($thisPartner['image'] !== $thisPartner['title'])) // and valid image saved
    {
        $sep = $modShow ? '' : '<br>';
        $thisPartner['image'] = $thisPartner['image'] . $sep . $thisPartner['title'];
    }

    if (isset($GLOBALS['xoopsUser']) && $xpHelper->isUserAdmin()) {
        $thisPartner['admin_option'] =
            "<a href='admin/main.php?op=editPartner&amp;id={$thisPartner['id']}'>"
          . "<img src='" . Admin::iconUrl('edit.png', '16') . "' alt='" . _EDIT . "' title='" . _EDIT . "'></a>&nbsp;"
          . "<a href='admin/main.php?op=delPartner&amp;id={$thisPartner['id']}'>"
          . "<img src='" . Admin::iconUrl('delete.png', '16') . "' alt='" . _DELETE . "' title='" . _DELETE . "'></a>";
    }
    $GLOBALS['xoopsTpl']->append('partners', $thisPartner);
}

$modLimit = (int)$modConfigs['modlimit'];
$pageNav  = null;
if (0 !== $modLimit) {
    $nav     = new XoopsPageNav($numPartners, $modLimit, $start);
    $pageNav = $nav->renderImageNav();
}
$GLOBALS['xoopsTpl']->assign(array(
                                 'lang_partner'      => _MD_XPARTNERS_PARTNER,
                                 'lang_desc'         => _MD_XPARTNERS_DESCRIPTION,
                                 'lang_hits'         => _MD_XPARTNERS_HITS,
                                 'lang_no_partners'  => _MD_XPARTNERS_NOPART,
                                 'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
                                //'sitename'          => $GLOBALS['xoopsConfig']['sitename'],
                                'pagenav'           => $pageNav
                             )
);
include_once __DIR__ . '/footer.php';
