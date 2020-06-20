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
 * @package      module\Xoopspartners\frontside
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */

use Xmf\Request;
use XoopsModules\Xoopspartners;

require_once __DIR__ . '/header.php';
$xpPartnersHandler = $helper->getHandler('Partners');

$id = Request::getInt('id', Xoopspartners\Constants::DEFAULT_PID, 'GET');
if (\Xoopspartners\Constants::DEFAULT_PID === $id) {
    $helper->redirect('index.php', Xoopspartners\Constants::REDIRECT_DELAY_MEDIUM, _MD_XOOPSPARTNERS_NOPART);
}

$partnerObj = $xpPartnersHandler->get($id);
if (($partnerObj instanceof \Xoopspartners\Partners)
    && $partnerObj->getVar('url')
    && (\Xoopspartners\Constants::STATUS_ACTIVE == $partnerObj->getVar('status'))) {
    if (!isset($GLOBALS['xoopsUser'])        // not a registered user
        || !$helper->isUserAdmin()         // registered but not an admin
        || $helper->getConfig('incadmin')) { // admin but want to include admin hits
        if (!isset($_COOKIE['partners'][$id])) {
            setcookie("partners[{$id}]", $id, time() + $helper->getConfig('cookietime'));
            $hitCount = $partnerObj->getVar('hits');
            ++$hitCount;
            $partnerObj->setVar('hits', $hitCount);
            $xpPartnersHandler->insert($partnerObj);
        }
    }
    echo "<html>\n" . "  <head>\n" . "    <meta http-equiv='Refresh' content='0; URL=" . htmlentities($partnerObj->getVar('url'), ENT_QUOTES | ENT_HTML5) . "'>\n" . "  </head>\n" . "  <body></body>\n" . "</html>\n";
} else {
    unset($xpPartnersHandler);
    $helper->redirect('index.php', Xoopspartners\Constants::REDIRECT_DELAY_MEDIUM, _MD_XOOPSPARTNERS_NOPART);
}
