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
 -------------------------------------------------------------------------
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
use Xmf\Request;
use Xmf\Module\Admin;

require __DIR__ . '/admin_header.php';
$moduleAdmin = Admin::getInstance();
$pathImageIcon = $GLOBALS['xoops']->url('www/' . $xpHelper->getModule()->getInfo('icons16'));
//$pathImageIcon = $GLOBALS['xoops']->url('www/' . $xpHelper->getModule()->getInfo('icons16'));

$myts = MyTextSanitizer::getInstance();

$op = Request::getString('op', '');
$id = Request::getInt('id', 0);

$del         = isset($_POST['del']) ? Request::getInt('del', XoopspartnersConstants::CONFIRM_NOT_OK, 'POST') : null;
$hits        = isset($_POST['hits']) ? Request::getInt('hits', 0, 'POST') : null;
$url         = isset($_POST['url']) ? Request::getString('url', '', 'POST') : null;
$image       = isset($_POST['image']) ? Request::getText('image', '', 'POST') : null;
$title       = isset($_POST['title']) ? Request::getString('title', '', 'POST') : null;
$description = isset($_POST['description']) ? Request::getText('description', '', 'POST') : null;
$status      = isset($_POST['status']) ? Request::getInt('status', array(), 'POST') : null;

switch ($op) {

    case 'partnersAdmin':
    default:
        $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));

        $moduleAdmin->displayNavigation('main.php');
        $moduleAdmin->addItemButton(_AM_XPARTNERS_ADD, 'main.php' . '?op=partnersAdminAdd', $icon = 'add');
        $moduleAdmin->displayButton();

        echo "  <form action='main.php' method='post' name='reorderform'>\n" . "    <table style='margin: 1px; padding: 0px;' class='outer width100 bnone'>\n" . "      <thead>\n" . "      <tr>\n" . "        <th class='txtcenter width20'>" . _AM_XPARTNERS_TITLE . "</th>\n"
             . "        <th style='width: 3%; text-align: center;'>" . _AM_XPARTNERS_IMAGE . "</th>\n" . '        <th>' . _AM_XPARTNERS_DESCRIPTION . "</th>\n" . "        <th class='width3 txtcenter'>" . _AM_XPARTNERS_ACTIVE . "</th>\n" . "        <th class='width3 txtcenter'>"
             . _AM_XPARTNERS_WEIGHT . "</th>\n" . "        <th class='width3 txtcenter'>" . _AM_XPARTNERS_HITS . "</th>\n" . "        <th class='width3 txtcenter'>" . _AM_XPARTNERS_ACTIONS . "</th>\n" . "      </tr>\n" . "      </thead>\n" . "      <tbody\n";

        $criteria = new CriteriaCompo();
        $criteria->setSort('status DESC, weight ASC, title');
        $criteria->setOrder('DESC');
        $partnerObjs = $xpPartnersHandler->getAll($criteria);
        $class       = 'even';
        $maxWidth    = $GLOBALS['xoopsModuleConfig']['maxwidth'];
        $maxHeight   = $GLOBALS['xoopsModuleConfig']['maxheight'];
        foreach ($partnerObjs as $partnerObj) {
            $url         = formatURL($partnerObj->getVar('url'));
            $image       = formatURL($partnerObj->getVar('image'));
            $title       = $partnerObj->getVar('title');
            $description = $partnerObj->getVar('description');
            //@TODO - find a way to check size of remote image if allow_url_fopen=0
            if ($imageInfo = @getimagesize($image)) {  //note this will "fail" if server set with allow_url_fopen=0
                $imageWidth  = $imageInfo[0];
                $imageHeight = $imageInfo[1];
                $errorMsg    = ($imageWidth > $maxWidth || $imageHeight > $maxHeight) ? '<br>' . _AM_XPARTNERS_IMAGE_ERROR : '';
            } else {
                $imageWidth  = $maxWidth;
                $imageHeight = $maxHeight;
                $errorMsg    = '';
            }
            if (1 == $partnerObj->getVar('status')) {
                $check1 = " selected='selected'";
                $check2 = '';
            } else {
                $check1 = '';
                $check2 = " selected='selected'";
            }
            echo "        <tr>\n" . "          <td class='{$class} width20 txtcenter alignmiddle'><a href='{$url}' rel='external'>{$title}</a></td>\n" . "          <td class='{$class} width3 txtcenter'>";
            if (!empty($image)) {
                echo "<img src='{$image}' alt='{$title}' style='width: " . (int)(.65 * $imageWidth) . 'px; height: ' . (int)(.65 * $imageHeight) . "px;'>{$errorMsg}";
            } else {
                echo '&nbsp;';
            }

            echo "        </td>\n" . "        <td class='{$class} alignmiddle'>{$description}</td>\n" . "        <td class='{$class} width3 txtcenter alignmiddle'>\n" . "          <select name='status[" . $partnerObj->getVar('id') . "]'>\n" . "            <option value='0'{$check2}>" . _NO
                 . "</option>\n" . "            <option value='1'{$check1}>" . _YES . "</option>\n" . "          </select>\n" . "        <td class='{$class} width3 txtcenter alignmiddle'>\n" . "          <input type='number' class='txtcenter' name='weight[" . $partnerObj->getVar('id') . "]' value='"
                 . $partnerObj->getVar('weight') . "' min='0' size='3'>\n" . "        </td>\n" . "        <td class='{$class} width3 txtcenter alignmiddle'>" . $partnerObj->getVar('hits') . "</td>\n" . "        <td class='{$class} width3 txtcenter alignmiddle'>\n"
                 . "          <a href='main.php?op=editPartner&amp;id=" . $partnerObj->getVar('id') . "'><img src='{$pathImageIcon}/edit.png' alt='" . _EDIT . "' title='" . _EDIT . "'></a>\n" . "          <a href='main.php?op=delPartner&amp;id=" . $partnerObj->getVar('id')
                 . "'><img src='{$pathImageIcon}/delete.png' alt='" . _DELETE . "' title='" . _DELETE . "'></a>\n" . "        </td>\n" . "      </tr>\n";
            $class = ($class == 'odd') ? 'even' : 'odd';
        }
        if (empty($partnerObjs)) {
            echo "<tr><td class='{$class} txtcenter bold line140' colspan='7'>" . _AM_XPARTNERS_NOPARTNERS . "</td></tr>\n";
            $adminButtons = '';
        } else {
            $adminButtons = "          <input type='button' name='button' onclick=\"location='main.php?op=reorderAutoPartners'\" value='" . _AM_XPARTNERS_AUTOMATIC_SORT . "'>\n" . "          <input type='submit' name='submit' value='" . _AM_XPARTNERS_UPDATE . "'>";

        }
        echo "      <tr>\n" . "        <td class='foot txtright' colspan='7'>\n" . "          <input type='hidden' name='op' value='reorderPartners'>\n"
             //            . "          <input type='button' name='button' onclick=\"location='main.php?op=partnersAdminAdd'\" value='" . _AM_XPARTNERS_ADD . "'>\n"
             . "{$adminButtons}\n" . "        </td>\n" . "      </tr>\n" . "      </tbody>\n" . "    </table>\n" . "  </form>\n";

        unset($partnerObjs);
        include __DIR__ . '/admin_footer.php';
        break;

    case 'reorderPartners':
        $weight = isset($_POST['weight']) ? Request::getArray('weight', array(), 'POST') : null;
        $status = isset($_POST['status']) ? Request::getArray('status', array(), 'POST') : null;

        $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));
        $partnerCount      = $xpPartnersHandler->getCount();
        if ($partnerCount) {
            foreach ($weight as $id => $order) {
                if ((int)$id > XoopspartnersConstants::DEFAULT_PID) {
                    $order   = ((!empty($order)) && ((int)$order > XoopspartnersConstants::DEFAULT_WEIGHT)) ? (int)$order : XoopspartnersConstants::DEFAULT_WEIGHT;
                    $stat    = (!empty($status[$id]) && ($status[$id] > XoopspartnersConstants::STATUS_INACTIVE)) ? (int)$status[$id] : XoopspartnersConstants::STATUS_INACTIVE;
                    $thisObj = $xpPartnersHandler->get($id);
                    if (!empty($thisObj) && ($thisObj instanceof XoopspartnersPartners)) {
                        $thisObj->setVars(array('weight' => $order, 'status' => $stat));
                        $xpPartnersHandler->insert($thisObj);
                        unset($thisObj);
                    }
                }
            }
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
        } else {
            redirect_header('main.php?op=partnersAdminAdd', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_EMPTYDATABASE, false);
        }
        break;

    case 'reorderAutoPartners':
        $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));
        $partnerObjs       = $xpPartnersHandler->getAll(null, array('weight'));
        $partnerCount      = count($partnerObjs);
        $weight            = XoopspartnersConstants::DEFAULT_WEIGHT;
        if ($partnerCount > 1) {
            foreach ($partnerObjs as $thisObj) {
                ++$weight;
                $thisObj->setVar('weight', $weight);
                $xpPartnersHandler->insert($thisObj);
                unset($thisObj);
            }
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
        } else {
            redirect_header('main.php?op=partnersAdminAdd', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_EMPTYDATABASE, false);
        }
        break;

    case 'partnersAdminAdd':
        $moduleAdmin->displayNavigation('main.php?op=partnersAdminAdd');
        //echo "<h4>"._AM_XPARTNERS_ADD."</h4>";

        include $GLOBALS['xoops']->path('/class/xoopsformloader.php');
        $form         = new XoopsThemeForm(_AM_XPARTNERS_ADDPARTNER, 'addform', 'main.php', 'post', true);
        $formWeight   = new XoopsFormText(_AM_XPARTNERS_WEIGHT, 'weight', 3, 10, XoopspartnersConstants::DEFAULT_WEIGHT);
        $formImage    = new XoopsFormText(_AM_XPARTNERS_IMAGE, 'image', 100, 150, 'http://');
        $formUrl      = new XoopsFormText(_AM_XPARTNERS_URL, 'url', 100, 150, 'http://');
        $formTitle    = new XoopsFormText(_AM_XPARTNERS_TITLE, 'title', 100, 150);
        $formDesc     = new XoopsFormTextArea(_AM_XPARTNERS_DESCRIPTION, 'description', '', 10, '60');
        $statOnTxt    = "&nbsp;<img src='{$pathImageIcon}/on.png' alt='" . _AM_XPARTNERS_ACTIVE . "'>&nbsp;" . _AM_XPARTNERS_ACTIVE . '&nbsp;&nbsp;&nbsp;';
        $statOffTxt   = "&nbsp;<img src='{$pathImageIcon}/off.png' alt='" . _AM_XPARTNERS_INACTIVE . "'>&nbsp;" . _AM_XPARTNERS_INACTIVE . '&nbsp;';
        $formStat     = new XoopsFormRadioYN(_AM_XPARTNERS_STATUS, 'status', XoopspartnersConstants::STATUS_ACTIVE, $statOnTxt, $statOffTxt);
        $opHidden     = new XoopsFormHidden('op', 'addPartner');
        $submitButton = new XoopsFormButton('', 'submit', _AM_XPARTNERS_ADDPARTNER, 'submit');
        $form->addElement($formTitle, true);
        $form->addElement($formImage);
        $form->addElement($formUrl, true);
        $form->addElement($formWeight);
        $form->addElement($formDesc, true);
        $form->addElement($formStat);
        $form->addElement($opHidden);
        $form->addElement($submitButton);
        $form->display();
        include __DIR__ . '/admin_footer.php';
        break;

    case 'addPartner':
        $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));
        $newPartner        = $xpPartnersHandler->create();
        $status            = ((!empty($status)) && ((int)$status > 0)) ? (int)$status : XoopspartnersConstants::STATUS_INACTIVE;
        $weight            = Request::getInt('weight', XoopspartnersConstants::DEFAULT_WEIGHT, 'POST');
        $title             = isset($title) ? trim($title) : '';
        $url               = isset($url) ? trim($url) : '';
        $image             = isset($image) ? trim($image) : '';
        $image             = $myts->addSlashes(formatURL($image));
        $description       = isset($description) ? trim($description) : '';
        if (empty($title) || empty($url) || empty($description)) {
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_BESURE);
        }
        $newPartner->setVars(array(
                                 'url'         => $myts->addSlashes(formatURL($url)),
                                 'image'       => $image,
                                 'title'       => $myts->addSlashes($title),
                                 'description' => $myts->addSlashes($description),
                                 'status'      => $status,
                                 'weight'      => $weight
                             ));

        if ($GLOBALS['xoopsSecurity']->check() && $xpPartnersHandler->insert($newPartner)) {
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
        } else {
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_NOTUPDATED . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        break;

    case 'editPartner':
        $moduleAdmin->displayNavigation('main.php');
        $id = ((int)$id > XoopspartnersConstants::DEFAULT_PID) ? (int)$id : XoopspartnersConstants::DEFAULT_PID;

        $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));
        $partnerObj        = $xpPartnersHandler->get($id);
        if (!empty($partnerObj) && ($partnerObj instanceof XoopspartnersPartners)) {
            $partnerVars = $partnerObj->getValues();
            //url, image, title, and description are all txtboxes so they have gone through htmlspecialchars via XoopsObject getVar

            include $GLOBALS['xoops']->path('/class/xoopsformloader.php');
            $form       = new XoopsThemeForm(_AM_XPARTNERS_EDITPARTNER, 'editform', 'main.php', 'post', true);
            $formWeight = new XoopsFormText(_AM_XPARTNERS_WEIGHT, 'weight', 3, 10, $partnerVars['weight']);
            $formHits   = new XoopsFormText(_AM_XPARTNERS_HITS, 'hits', 3, 10, $partnerVars['hits']);
            $formImage  = new XoopsFormText(_AM_XPARTNERS_IMAGE, 'image', 50, 150, $partnerVars['image']);
            $formUrl    = new XoopsFormText(_AM_XPARTNERS_URL, 'url', 50, 150, $partnerVars['url']);
            $formTitle  = new XoopsFormText(_AM_XPARTNERS_TITLE, 'title', 50, 150, $partnerVars['title']);
            $formDesc   = new XoopsFormTextArea(_AM_XPARTNERS_DESCRIPTION, 'description', $partnerVars['description'], 10, '100%');

            $statOnTxt  = "&nbsp;<img src='{$pathImageIcon}/on.png' alt='" . _AM_XPARTNERS_ACTIVE . "'>&nbsp;" . _AM_XPARTNERS_ACTIVE . '&nbsp;&nbsp;&nbsp;';
            $statOffTxt = "&nbsp;<img src='{$pathImageIcon}/off.png' alt='" . _AM_XPARTNERS_INACTIVE . "'>&nbsp;" . _AM_XPARTNERS_INACTIVE . '&nbsp;';
            $formStat   = new XoopsFormRadioYN(_AM_XPARTNERS_STATUS, 'status', $partnerVars['status'], $statOnTxt, $statOffTxt);

            $submitButton = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
            $form->addElement($formTitle, true);
            $form->addElement($formImage);
            $form->addElement($formUrl, true);
            $form->addElement($formWeight);
            $form->addElement($formDesc, true);
            $form->addElement($formHits);
            $form->addElement($formStat);
            $form->addElement(new XoopsFormHidden('id', $id));
            $form->addElement(new XoopsFormHidden('op', 'updatePartner'));
            $form->addElement($submitButton);
            $form->display();
            include __DIR__ . '/admin_footer.php';
        } else {
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_INVALIDID);
        }
        break;

    case 'updatePartner':
        $title       = isset($title) ? trim($title) : '';
        $image       = isset($image) ? trim($image) : '';
        $image       = $myts->addSlashes(formatURL($image));
        $url         = isset($url) ? trim($url) : '';
        $description = isset($description) ? trim($description) : '';
        $id          = ($id > XoopspartnersConstants::DEFAULT_PID) ? $id : XoopspartnersConstants::DEFAULT_PID;
        $status      = ((!empty($status)) && ($status > XoopspartnersConstants::STATUS_INACTIVE)) ? (int)$status : XoopspartnersConstants::STATUS_INACTIVE;
        $weight      = Request::getInt('weight', XoopspartnersConstants::DEFAULT_WEIGHT, 'POST');
        $weight      = $weight > XoopspartnersConstants::DEFAULT_WEIGHT ? $weight : XoopspartnersConstants::DEFAULT_WEIGHT;
        $hits        = ((!empty($hits)) && ((int)$hits > 0)) ? (int)$hits : 0;
        if ($title == '' || $url == '' || empty($id) || $description == '') {
            redirect_header("main.php?op=edit_partner&amp;id={$id}", XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_BESURE);
        }
        /*
            if (!empty($image)) {
                $image_info   = exif_imagetype($image);;
                if (false === $image_info) {
                    redirect_header("main.php?op=edit_partner&amp;id={$id}", 1, _AM_XPARTNERS_NOEXIST);
                }
            }
        */
        $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));
        $partnerObj        = $xpPartnersHandler->get($id);
        if ($GLOBALS['xoopsSecurity']->check() && ($partnerObj instanceof XoopspartnersPartners)) {
            $partnerObj->setVar('url', $myts->addSlashes(formatURL($url)));
            $partnerObj->setVar('title', $myts->addSlashes($title));
            $partnerObj->setVar('description', $myts->addSlashes($description));
            $partnerObj->setVar('hits', $hits);
            $partnerObj->setVar('weight', $weight);
            $partnerObj->setVar('status', $status);
            $partnerObj->setVar('image', $image);
            $success = $xpPartnersHandler->insert($partnerObj);
            if ($success) {
                redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
            }
        }
        redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_NOTUPDATED . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        break;

    case 'delPartner':
        if ((XoopspartnersConstants::CONFIRM_OK == $del) && ($id > XoopspartnersConstants::DEFAULT_PID)) {
            $xpPartnersHandler = xoops_getModuleHandler('partners', $GLOBALS['xoopsModule']->getVar('dirname'));
            $partnerObj        = $xpPartnersHandler->get($id);
            if ($partnerObj instanceof XoopspartnersPartners) {
                if ($xpPartnersHandler->delete($partnerObj)) {
                    redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
                }
            }
            redirect_header('main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_NOTUPDATED);
        } else {
            $moduleAdmin->displayNavigation('main.php');
            xoops_confirm(array('op' => 'delPartner', 'id' => (int)$id, 'del' => XoopspartnersConstants::CONFIRM_OK), 'main.php', _AM_XPARTNERS_SUREDELETE);
            include __DIR__ . '/admin_footer.php';
        }
        break;
}
