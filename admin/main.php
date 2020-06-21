<?php
/*
 * You may not change or alter any portion of this comment or credits of
 * supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit
 * authors.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * -----------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 * -----------------------------------
*/

/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\admin
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 * @since        1.11
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Xoopspartners;
use XoopsModules\Xoopspartners\Constants;

require_once __DIR__ . '/admin_header.php';
$moduleAdmin   = Admin::getInstance();
$pathImageIcon = $GLOBALS['xoops']->url('www/' . $helper->getModule()->getInfo('icons16'));

$myts = \MyTextSanitizer::getInstance();

$op          = Request::getString('op', '');
$id          = Request::getInt('id', 0);
$del         = Request::getInt('del', Constants::CONFIRM_NOT_OK, 'POST');
$hits        = Request::getInt('hits', 0, 'POST');
$url         = Request::getString('url', '', 'POST');
$image       = Request::getText('image', '', 'POST');
$title       = Request::getString('title', '', 'POST');
$description = Request::getText('description', '', 'POST');
//$status        = isset($_POST['status']) ? Request::getInt('status', array(), 'POST') : null;
$status = isset($_POST['status']) ? is_array($_POST['status']) ? Request::getArray('status', [], 'POST') : Request::getInt('status', Constants::STATUS_INACTIVE, 'POST') : null;
$weight = isset($_POST['weight']) ? is_array($_POST['weight']) ? Request::getArray('weight', [], 'POST') : Request::getInt('weight', Constants::DEFAULT_WEIGHT, 'POST') : null;

switch ($op) {
    case 'partnersAdmin':
    default:
        $partnersHandler = $helper->getHandler('Partners');

        $moduleAdmin->displayNavigation('main.php');
        $moduleAdmin->addItemButton(_AM_XOOPSPARTNERS_ADD, 'main.php' . '?op=partnersAdminAdd', $icon = 'add');
        $moduleAdmin->displayButton();

        echo "  <form action='main.php' method='post' name='reorderform'>\n"
             . "    <table style='margin: 1px; padding: 0;' class='outer width100 bnone'>\n"
             . "      <thead>\n"
             . "      <tr>\n"
             . "        <th class='center width20'>"
             . _AM_XOOPSPARTNERS_TITLE
             . "</th>\n"
             . "        <th class='center width10'>"
             . _AM_XOOPSPARTNERS_IMAGE
             . "</th>\n"
             . '        <th>'
             . _AM_XOOPSPARTNERS_DESCRIPTION
             . "</th>\n"
             . "        <th class='center width5'>"
             . _AM_XOOPSPARTNERS_ACTIVE
             . "</th>\n"
             . "        <th class='center width5'>"
             . _AM_XOOPSPARTNERS_WEIGHT
             . "</th>\n"
             . "        <th class='center width5'>"
             . _AM_XOOPSPARTNERS_HITS
             . "</th>\n"
             . "        <th class='center width10'>"
             . _AM_XOOPSPARTNERS_ACTIONS
             . "</th>\n"
             . "      </tr>\n"
             . "      </thead>\n"
             . "      <tbody\n";

        $criteria = new \CriteriaCompo();
        $criteria->setSort('status DESC, weight ASC, title');
        $criteria->setOrder('DESC');
        $partnerObjs = $partnersHandler->getAll($criteria);
        $class       = 'even';
        $maxWidth    = $GLOBALS['xoopsModuleConfig']['maxwidth'];
        $maxHeight   = $GLOBALS['xoopsModuleConfig']['maxheight'];
        foreach ($partnerObjs as $partnerObj) {
            $url         = formatURL($partnerObj->getVar('url'));
            $image       = formatURL($partnerObj->getVar('image'));
            $title       = $partnerObj->getVar('title');
            $description = $partnerObj->getVar('description');
            //@todo - find a way to check size of remote image if allow_url_fopen=0
            $imageInfo = @getimagesize($image);
            if ($imageInfo) {  //note this will "fail" if server allow_url_fopen=0
                $imageWidth  = $imageInfo[0];
                $imageHeight = $imageInfo[1];
                $errorMsg    = ($imageWidth > $maxWidth || $imageHeight > $maxHeight) ? '<br>' . _AM_XOOPSPARTNERS_IMAGE_ERROR : '';
            } else {
                $imageWidth  = $maxWidth;
                $imageHeight = $maxHeight;
                $errorMsg    = '';
            }
            if (1 == $partnerObj->getVar('status')) {
                $check1 = ' selected';
                $check2 = '';
            } else {
                $check1 = '';
                $check2 = ' selected';
            }
            echo "        <tr>\n" . "          <td class='{$class} width20 center middle'>" . "<a href='{$url}' rel='external'>{$title}</a>" . "</td>\n" . "          <td class='{$class} width3 center'>";
            if (!empty($image)) {
                echo "<img src='{$image}' alt='{$title}' " . "style='width: " . (int)(.65 * $imageWidth) . 'px; ' . 'height: ' . (int)(.65 * $imageHeight) . "px;'>" . $errorMsg;
            } else {
                echo '&nbsp;';
            }

            echo "</td>\n"
                 . "        <td class='{$class} middle'>{$description}</td>\n"
                 . "        <td class='{$class} width3 center middle'>\n"
                 . "          <select name='status["
                 . $partnerObj->getVar('id')
                 . "]'>\n"
                 . "            <option value='0'{$check2}>"
                 . _NO
                 . "</option>\n"
                 . "            <option value='1'{$check1}>"
                 . _YES
                 . "</option>\n"
                 . "          </select>\n"
                 . "        <td class='{$class} width3 center middle'>\n"
                 . "          <input type='number' name='weight["
                 . $partnerObj->getVar('id')
                 . "]' "
                 . "class='center' value='"
                 . $partnerObj->getVar('weight')
                 . "' min='0' size='3'>\n"
                 . "        </td>\n"
                 . "        <td class='{$class} width3 center middle'>"
                 . $partnerObj->getVar('hits')
                 . "</td>\n"
                 . "        <td class='{$class} width3 center middle'>\n"
                 . "          <a href='main.php?op=editPartner&amp;id="
                 . $partnerObj->getVar('id')
                 . "'>"
                 . "<img src='"
                 . Admin::iconUrl('edit.png', '16')
                 . "' "
                 . "class='tooltip floatcenter1' "
                 . "alt='"
                 . _EDIT
                 . "' "
                 . "title='"
                 . _EDIT
                 . "'>"
                 . "</a>\n"
                 . "          <a href='main.php?op=delPartner&amp;id="
                 . $partnerObj->getVar('id')
                 . "'>"
                 . "<img src='"
                 . Admin::iconUrl('delete.png', '16')
                 . "' "
                 . "class='tooltip floatcenter1' "
                 . "alt='"
                 . _DELETE
                 . "' "
                 . "title='"
                 . _DELETE
                 . "'>"
                 . "</a>\n"
                 . '           '
                 . $GLOBALS['xoopsSecurity']->getTokenHTML()
                 . "\n"
                 . "        </td>\n"
                 . "      </tr>\n";
            $class = ('odd' === $class) ? 'even' : 'odd';
        }
        if (empty($partnerObjs)) {
            echo "      <tr>\n" . "        <td class='{$class} center bold line140' colspan='7'>" . _AM_XOOPSPARTNERS_NOPARTNERS . "</td>\n" . "      </tr>\n";
            $adminButtons = '';
        } else {
            $adminButtons = "        <input type='button' " . "name='button' " . "onclick=\"location='main.php?op=reorderAutoPartners'\" " . "value='" . _AM_XOOPSPARTNERS_AUTOMATIC_SORT . "'>\n" . "        <input type='submit' name='submit' value='" . _AM_XOOPSPARTNERS_UPDATE . "'>";
        }
        echo "      <tr>\n" . "        <td class='foot right' colspan='7'>\n" . "        <input type='hidden' name='op' value='reorderPartners'>\n" . "{$adminButtons}\n" . "        </td>\n" . "      </tr>\n" . "      </tbody>\n" . "    </table>\n" . "  </form>\n";

        unset($partnerObjs);
        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'reorderPartners':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_MEDIUM, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $partnersHandler = $helper->getHandler('Partners');
        $partnerCount      = $partnersHandler->getCount();
        if ($partnerCount) {
            foreach ($weight as $id => $order) {
                if ((int)$id > Constants::DEFAULT_PID) {
                    $order   = (!empty($order) && ((int)$order > Constants::DEFAULT_WEIGHT)) ? (int)$order : Constants::DEFAULT_WEIGHT;
                    $stat    = (!empty($status[$id]) && ($status[$id] > Constants::STATUS_INACTIVE)) ? (int)$status[$id] : Constants::STATUS_INACTIVE;
                    $thisObj = $partnersHandler->get($id);
                    if (!empty($thisObj) && ($thisObj instanceof Xoopspartners\Partners)) {
                        $thisObj->setVars(['weight' => $order, 'status' => $stat]);
                        $partnersHandler->insert($thisObj);
                        unset($thisObj);
                    }
                }
            }
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_SHORT, _AM_XOOPSPARTNERS_UPDATED);
        } else {
            $helper->redirect('admin/main.php?op=partnersAdminAdd', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_EMPTYDATABASE, false);
        }
        break;
    case 'reorderAutoPartners':
        $partnersHandler = $helper->getHandler('Partners');
        $partnerObjs       = $partnersHandler->getAll(null, ['weight']);
        $partnerCount      = count($partnerObjs);
        $weight            = Constants::DEFAULT_WEIGHT;
        if ($partnerCount > 1) {
            foreach ($partnerObjs as $thisObj) {
                ++$weight;
                $thisObj->setVar('weight', $weight);
                $partnersHandler->insert($thisObj);
                unset($thisObj);
            }
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_SHORT, _AM_XOOPSPARTNERS_UPDATED);
        } else {
            $helper->redirect('admin/main.php?op=partnersAdminAdd', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_EMPTYDATABASE, false);
        }
        break;
    case 'partnersAdminAdd':
        $moduleAdmin->displayNavigation('main.php?op=partnersAdminAdd');

        require_once $GLOBALS['xoops']->path('/class/xoopsformloader.php');
        $form         = new \XoopsThemeForm(_AM_XOOPSPARTNERS_ADDPARTNER, 'addform', 'main.php', 'post', true);
        $formWeight   = new \XoopsFormText(_AM_XOOPSPARTNERS_WEIGHT, 'weight', 3, 10, Constants::DEFAULT_WEIGHT);
        $formImage    = new \XoopsFormText(_AM_XOOPSPARTNERS_IMAGE, 'image', 50, 150, 'http://');
        $formUrl      = new \XoopsFormText(_AM_XOOPSPARTNERS_URL, 'url', 50, 150, 'http://');
        $formTitle    = new \XoopsFormText(_AM_XOOPSPARTNERS_TITLE, 'title', 50, 50);
        $formDesc     = new \XoopsFormTextArea(_AM_XOOPSPARTNERS_DESCRIPTION, 'description', '', 5, 51);
        $statOnTxt    = "<img src='" . Admin::iconUrl('on.png', '16') . "' " . "class='tooltip floatcenter1' " . "alt='" . _AM_XOOPSPARTNERS_ACTIVE . "'>" . '&nbsp;' . _AM_XOOPSPARTNERS_ACTIVE;
        $statOffTxt   = "<img src='" . Admin::iconUrl('off.png', '16') . "' " . "class='tooltip floatcenter1' " . "alt='" . _AM_XOOPSPARTNERS_INACTIVE . "'>" . '&nbsp;' . _AM_XOOPSPARTNERS_INACTIVE;
        $formStat     = new \XoopsFormRadioYN(_AM_XOOPSPARTNERS_STATUS, 'status', Constants::STATUS_ACTIVE, $statOnTxt, $statOffTxt);
        $opHidden     = new \XoopsFormHidden('op', 'addPartner');
        $submitButton = new \XoopsFormButton('', 'submit', _AM_XOOPSPARTNERS_ADDPARTNER, 'submit');
        $form->addElement($formTitle, true);
        $form->addElement($formImage);
        $form->addElement($formUrl, true);
        $form->addElement($formWeight);
        $form->addElement($formDesc, true);
        $form->addElement($formStat);
        $form->addElement($opHidden);
        $form->addElement($submitButton);
        $form->display();
        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'addPartner':
        $partnersHandler = $helper->getHandler('Partners');
        $newPartner        = $partnersHandler->create();
        $status            = (!empty($status) && ((int)$status > 0)) ? (int)$status : Constants::STATUS_INACTIVE;
        $weight            = Request::getInt('weight', Constants::DEFAULT_WEIGHT, 'POST');
        $title             = trim($title);
        $url               = trim($url);
        $image             = trim($image);
        $image             = $myts->addSlashes(formatURL($image));
        $description       = trim($description);
        if (empty($title) || empty($url) || empty($description)) {
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_BESURE);
        }
        $newPartner->setVars(
            [
                'url'         => $myts->addSlashes(formatURL($url)),
                'image'       => $image,
                'title'       => $myts->addSlashes($title),
                'description' => $myts->addSlashes($description),
                'status'      => $status,
                'weight'      => $weight,
            ]
        );

        if ($GLOBALS['xoopsSecurity']->check() && $partnersHandler->insert($newPartner)) {
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_SHORT, _AM_XOOPSPARTNERS_UPDATED);
        } else {
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_NOTUPDATED . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        break;
    case 'editPartner':
        $moduleAdmin->displayNavigation('main.php');
        $id = $id > Constants::DEFAULT_PID ? $id : Constants::DEFAULT_PID;

        $partnersHandler = $helper->getHandler('Partners');
        $partnerObj        = $partnersHandler->get($id);
        if (!empty($partnerObj) && ($partnerObj instanceof Xoopspartners\Partners)) {
            $partnerVars = $partnerObj->getValues();
            /*url, image, title, and description are all txtboxes so they have gone through
             * htmlspecialchars via XoopsObject getVar
             */
            require_once $GLOBALS['xoops']->path('/class/xoopsformloader.php');
            $form       = new \XoopsThemeForm(_AM_XOOPSPARTNERS_EDITPARTNER, 'editform', 'main.php', 'post', true);
            $formWeight = new \XoopsFormText(_AM_XOOPSPARTNERS_WEIGHT, 'weight', 3, 10, $partnerVars['weight']);
            $formHits   = new \XoopsFormText(_AM_XOOPSPARTNERS_HITS, 'hits', 3, 10, $partnerVars['hits']);
            $formImage  = new \XoopsFormText(_AM_XOOPSPARTNERS_IMAGE, 'image', 50, 150, $partnerVars['image']);
            $formUrl    = new \XoopsFormText(_AM_XOOPSPARTNERS_URL, 'url', 50, 150, $partnerVars['url']);
            $formTitle  = new \XoopsFormText(_AM_XOOPSPARTNERS_TITLE, 'title', 50, 50, $partnerVars['title']);
            $formDesc   = new \XoopsFormTextArea(_AM_XOOPSPARTNERS_DESCRIPTION, 'description', $partnerVars['description'], 5, 51);
            $statOnTxt  = "<img src='" . Admin::iconUrl('on.png', '16') . "' " . "class='tooltip floatcenter1' " . "alt='" . _AM_XOOPSPARTNERS_ACTIVE . "'>" . _AM_XOOPSPARTNERS_ACTIVE;
            $statOffTxt = "<img src='" . Admin::iconUrl('off.png', '16') . "' " . "class='tooltip floatcenter1' " . "alt='" . _AM_XOOPSPARTNERS_INACTIVE . "'>" . _AM_XOOPSPARTNERS_INACTIVE;
            $formStat   = new \XoopsFormRadioYN(_AM_XOOPSPARTNERS_STATUS, 'status', $partnerVars['status'], $statOnTxt, $statOffTxt);

            $submitButton = new \XoopsFormButton('', 'submit', _SUBMIT, 'submit');
            $form->addElement($formTitle, true);
            $form->addElement($formImage);
            $form->addElement($formUrl, true);
            $form->addElement($formWeight);
            $form->addElement($formDesc, true);
            $form->addElement($formHits);
            $form->addElement($formStat);
            $form->addElement(new \XoopsFormHidden('id', $id));
            $form->addElement(new \XoopsFormHidden('op', 'updatePartner'));
            $form->addElement($submitButton);
            $form->display();
            require_once __DIR__ . '/admin_footer.php';
        } else {
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_INVALIDID);
        }
        break;
    case 'updatePartner':
        $title       = trim($title);
        $image       = trim($image);
        $image       = $myts->addSlashes(formatURL($image));
        $url         = trim($url);
        $description = trim($description);
        $id          = ($id > Constants::DEFAULT_PID) ? $id : Constants::DEFAULT_PID;
        $status      = (!empty($status) && ($status > Constants::STATUS_INACTIVE)) ? (int)$status : Constants::STATUS_INACTIVE;
        $weight      = Request::getInt('weight', Constants::DEFAULT_WEIGHT, 'POST');
        $weight      = $weight > Constants::DEFAULT_WEIGHT ? $weight : Constants::DEFAULT_WEIGHT;
        $hits        = $hits > 0 ? $hits : 0;
        if (empty($title) || empty($url) || empty($id) || empty($description)) {
            $helper->redirect("admin/main.php?op=edit_partner&amp;id={$id}", Constants::REDIRECT_DELAY_SHORT, _AM_XOOPSPARTNERS_BESURE);
        }

        $partnersHandler = $helper->getHandler('Partners');
        $partnerObj        = $partnersHandler->get($id);
        if ($GLOBALS['xoopsSecurity']->check() && ($partnerObj instanceof Xoopspartners\Partners)) {
            $partnerObj->setVar('url', $myts->addSlashes(formatURL($url)));
            $partnerObj->setVar('title', $myts->addSlashes($title));
            $partnerObj->setVar('description', $myts->addSlashes($description));
            $partnerObj->setVar('hits', $hits);
            $partnerObj->setVar('weight', $weight);
            $partnerObj->setVar('status', $status);
            $partnerObj->setVar('image', $image);
            $success = $partnersHandler->insert($partnerObj);
            if ($success) {
                $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_SHORT, _AM_XOOPSPARTNERS_UPDATED);
            }
        }
        $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_NOTUPDATED . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        break;
    case 'delPartner':
        if ((Constants::CONFIRM_OK === $del) && ($id > Constants::DEFAULT_PID)) {
            $partnersHandler = $helper->getHandler('Partners');
            $partnerObj        = $partnersHandler->get($id);
            if ($partnerObj instanceof Xoopspartners\Partners) {
                if ($partnersHandler->delete($partnerObj)) {
                    $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_SHORT, _AM_XOOPSPARTNERS_UPDATED);
                }
            }
            $helper->redirect('admin/main.php', Constants::REDIRECT_DELAY_MEDIUM, _AM_XOOPSPARTNERS_NOTUPDATED);
        } else {
            $moduleAdmin->displayNavigation('main.php');
            xoops_confirm(
                [
                    'op'  => 'delPartner',
                    'id'  => $id,
                    'del' => Constants::CONFIRM_OK,
                ],
                'main.php',
                _AM_XOOPSPARTNERS_SUREDELETE
            );
            require_once __DIR__ . '/admin_footer.php';
        }
        break;
}
