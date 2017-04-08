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
 * @package      module\xoopspartners\admin
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    http://xoops.org 2001-2016 &copy; XOOPS Project
 * @license      http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @since        1.11
 */
use Xmf\Request;
use Xmf\Module\Admin;

require __DIR__ . '/admin_header.php';
$moduleAdmin   = Admin::getInstance();
$pathImageIcon = $GLOBALS['xoops']->url('www/' . $xpHelper->getModule()->getInfo('icons16'));

$myts          = MyTextSanitizer::getInstance();

$op            = Request::getString('op', '');
$id            = Request::getInt('id', 0);
$del           = Request::getInt('del', XoopspartnersConstants::CONFIRM_NOT_OK, 'POST');
$hits          = Request::getInt('hits', 0, 'POST');
$url           = Request::getString('url', '', 'POST');
$image         = Request::getText('image', '', 'POST');
$title         = Request::getString('title', '', 'POST');
$description   = Request::getText('description', '', 'POST');
//$status        = isset($_POST['status']) ? Request::getInt('status', array(), 'POST') : null;
$status        = isset($_POST['status'])
                     ? is_array($_POST['status'])
                         ? Request::getArray('status', array(), 'POST')
                         : Request::getInt('status', XoopspartnersConstants::STATUS_INACTIVE, 'POST')
                     : null;
$weight        = isset($_POST['weight'])
                     ? is_array($_POST['weight'])
                         ? Request::getArray('weight', array(), 'POST')
                         : Request::getInt('weight', XoopspartnersConstants::DEFAULT_WEIGHT, 'POST')
                     : null;

switch ($op) {

    case 'partnersAdmin':
    default:
        $xpPartnersHandler = $xpHelper->getHandler('partners');

        $moduleAdmin->displayNavigation('main.php');
        $moduleAdmin->addItemButton(_AM_XPARTNERS_ADD, 'main.php' . '?op=partnersAdminAdd', $icon = 'add');
        $moduleAdmin->displayButton();

        echo "  <form action='main.php' method='post' name='reorderform'>\n"
           . "    <table style='margin: 1px; padding: 0px;' class='outer width100 bnone'>\n"
           . "      <thead>\n"
           . "      <tr>\n"
           . "        <th class='center width20'>" . _AM_XPARTNERS_TITLE . "</th>\n"
           . "        <th class='center width10'>" . _AM_XPARTNERS_IMAGE . "</th>\n"
           . "        <th>" . _AM_XPARTNERS_DESCRIPTION . "</th>\n"
           . "        <th class='center width5'>" . _AM_XPARTNERS_ACTIVE . "</th>\n"
           . "        <th class='center width5'>" . _AM_XPARTNERS_WEIGHT . "</th>\n"
           . "        <th class='center width5'>" . _AM_XPARTNERS_HITS . "</th>\n"
           . "        <th class='center width10'>" . _AM_XPARTNERS_ACTIONS . "</th>\n"
           . "      </tr>\n"
           . "      </thead>\n"
           . "      <tbody\n";

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
            //@todo - find a way to check size of remote image if allow_url_fopen=0
            if ($imageInfo = @getimagesize($image)) {  //note this will "fail" if server allow_url_fopen=0
                $imageWidth  = $imageInfo[0];
                $imageHeight = $imageInfo[1];
                $errorMsg    = ($imageWidth > $maxWidth || $imageHeight > $maxHeight)
                               ? '<br>' . _AM_XPARTNERS_IMAGE_ERROR
                               : '';
            } else {
                $imageWidth  = $maxWidth;
                $imageHeight = $maxHeight;
                $errorMsg    = '';
            }
            if (1 == $partnerObj->getVar('status')) {
                $check1 = " selected";
                $check2 = '';
            } else {
                $check1 = '';
                $check2 = " selected";
            }
            echo "        <tr>\n"
               . "          <td class='{$class} width20 center middle'>"
                            . "<a href='{$url}' rel='external'>{$title}</a>"
                            . "</td>\n"
               . "          <td class='{$class} width3 center'>";
            if (!empty($image)) {
                echo "<img src='{$image}' alt='{$title}' "
                     . "style='width: " . (int)(.65 * $imageWidth) . "px; "
                     . "height: " . (int)(.65 * $imageHeight) . "px;'>"
                   . $errorMsg;
            } else {
                echo '&nbsp;';
            }

            echo         "</td>\n"
               . "        <td class='{$class} middle'>{$description}</td>\n"
               . "        <td class='{$class} width3 center middle'>\n"
               . "          <select name='status[" . $partnerObj->getVar('id') . "]'>\n"
               . "            <option value='0'{$check2}>" . _NO . "</option>\n"
               . "            <option value='1'{$check1}>" . _YES . "</option>\n"
               . "          </select>\n"
               . "        <td class='{$class} width3 center middle'>\n"
               . "          <input type='number' name='weight[" . $partnerObj->getVar('id') . "]' "
               .              "class='center' value='" . $partnerObj->getVar('weight') . "' min='0' size='3'>\n"
               . "        </td>\n"
               . "        <td class='{$class} width3 center middle'>" . $partnerObj->getVar('hits') . "</td>\n"
               . "        <td class='{$class} width3 center middle'>\n"
               . "          <a href='main.php?op=editPartner&amp;id=" . $partnerObj->getVar('id') . "'>"
               .              "<img src='" . Admin::iconUrl('edit.png', '16') . "' "
               .                "class='tooltip floatcenter1' "
               .                "alt='" . _EDIT . "' "
               .                "title='" . _EDIT . "'>"
               .            "</a>\n"
               . "          <a href='main.php?op=delPartner&amp;id=" . $partnerObj->getVar('id') . "'>"
               .              "<img src='" . Admin::IconUrl('delete.png', '16') . "' "
               .                "class='tooltip floatcenter1' "
               .                "alt='" . _DELETE . "' "
               .                "title='" . _DELETE . "'>"
               .            "</a>\n"
               . "           " . $GLOBALS['xoopsSecurity']->getTokenHTML() . "\n"
               . "        </td>\n"
               . "      </tr>\n";
            $class = ('odd' == $class) ? 'even' : 'odd';
        }
        if (empty($partnerObjs)) {
            echo "      <tr>\n"
               . "        <td class='{$class} center bold line140' colspan='7'>" . _AM_XPARTNERS_NOPARTNERS . "</td>\n"
               . "      </tr>\n";
            $adminButtons = '';
        } else {
            $adminButtons = "        <input type='button' "
                                     . "name='button' "
                                     . "onclick=\"location='main.php?op=reorderAutoPartners'\" "
                                     . "value='" . _AM_XPARTNERS_AUTOMATIC_SORT . "'>\n"
                          . "        <input type='submit' name='submit' value='" . _AM_XPARTNERS_UPDATE . "'>";

        }
        echo "      <tr>\n"
           . "        <td class='foot right' colspan='7'>\n"
           . "        <input type='hidden' name='op' value='reorderPartners'>\n"
           . "{$adminButtons}\n"
           . "        </td>\n"
           . "      </tr>\n"
           . "      </tbody>\n"
           . "    </table>\n"
           . "  </form>\n";

        unset($partnerObjs);
        include __DIR__ . '/admin_footer.php';
        break;

    case 'reorderPartners':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $xpHelper->url('admin/main.php',
                            XoopsPartnersConstants::REDIRECT_DELAY_MEDIUM,
                            implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $xpPartnersHandler = $xpHelper->getHandler('partners');
        $partnerCount      = $xpPartnersHandler->getCount();
        if ($partnerCount) {
            foreach ($weight as $id => $order) {
                if ((int)$id > XoopspartnersConstants::DEFAULT_PID) {
                    $order   = ((!empty($order)) && ((int)$order > XoopspartnersConstants::DEFAULT_WEIGHT))
                                ? (int)$order
                                : XoopspartnersConstants::DEFAULT_WEIGHT;
                    $stat    = (!empty($status[$id]) && ($status[$id] > XoopspartnersConstants::STATUS_INACTIVE))
                                ? (int)$status[$id]
                                : XoopspartnersConstants::STATUS_INACTIVE;
                    $thisObj = $xpPartnersHandler->get($id);
                    if (!empty($thisObj) && ($thisObj instanceof XoopspartnersPartners)) {
                        $thisObj->setVars(array('weight' => $order, 'status' => $stat));
                        $xpPartnersHandler->insert($thisObj);
                        unset($thisObj);
                    }
                }
            }
            $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
        } else {
            $xpHelper->url('admin/main.php?op=partnersAdminAdd',
                            XoopspartnersConstants::REDIRECT_DELAY_MEDIUM,
                            _AM_XPARTNERS_EMPTYDATABASE, false
            );
        }
        break;

    case 'reorderAutoPartners':
        $xpPartnersHandler = $xpHelper->getHandler('partners');
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
            $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
        } else {
            $xpHelper->url('admin/main.php?op=partnersAdminAdd',
                            XoopspartnersConstants::REDIRECT_DELAY_MEDIUM,
                            _AM_XPARTNERS_EMPTYDATABASE, false
            );
        }
        break;

    case 'partnersAdminAdd':
        $moduleAdmin->displayNavigation('main.php?op=partnersAdminAdd');

        include $GLOBALS['xoops']->path('/class/xoopsformloader.php');
        $form         = new XoopsThemeForm(_AM_XPARTNERS_ADDPARTNER, 'addform', 'main.php', 'post', true);
        $formWeight   = new XoopsFormText(_AM_XPARTNERS_WEIGHT,
                                          'weight',
                                          3,
                                          10,
                                          XoopspartnersConstants::DEFAULT_WEIGHT
        );
        $formImage    = new XoopsFormText(_AM_XPARTNERS_IMAGE, 'image', 50, 150, 'http://');
        $formUrl      = new XoopsFormText(_AM_XPARTNERS_URL, 'url', 50, 150, 'http://');
        $formTitle    = new XoopsFormText(_AM_XPARTNERS_TITLE, 'title', 50, 50);
        $formDesc     = new XoopsFormTextArea(_AM_XPARTNERS_DESCRIPTION, 'description', '', 5, 51);
        $statOnTxt    = "<img src='" . Admin::iconUrl('on.png', '16') . "' "
                      .   "class='tooltip floatcenter1' "
                      .   "alt='" . _AM_XPARTNERS_ACTIVE . "'>"
                      .   "&nbsp;" . _AM_XPARTNERS_ACTIVE;
        $statOffTxt   = "<img src='" . Admin::iconUrl('off.png', '16') . "' "
                      .   "class='tooltip floatcenter1' "
                      .   "alt='" . _AM_XPARTNERS_INACTIVE . "'>"
                      .   "&nbsp;" . _AM_XPARTNERS_INACTIVE;
        $formStat     = new XoopsFormRadioYN(_AM_XPARTNERS_STATUS,
                                             'status',
                                             XoopspartnersConstants::STATUS_ACTIVE,
                                             $statOnTxt,
                                             $statOffTxt
        );
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
        $xpPartnersHandler = $xpHelper->getHandler('partners');
        $newPartner        = $xpPartnersHandler->create();
        $status            = ((!empty($status)) && ((int)$status > 0))
                             ? (int)$status
                             : XoopspartnersConstants::STATUS_INACTIVE;
        $weight            = Request::getInt('weight', XoopspartnersConstants::DEFAULT_WEIGHT, 'POST');
        $title             = trim($title);
        $url               = trim($url);
        $image             = trim($image);
        $image             = $myts->addSlashes(formatURL($image));
        $description       = trim($description);
        if (empty($title) || empty($url) || empty($description)) {
            $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_BESURE);
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
            $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
        } else {
            $xpHelper->url('admin/main.php',
                            XoopspartnersConstants::REDIRECT_DELAY_MEDIUM,
                            _AM_XPARTNERS_NOTUPDATED . '<br>'
                            . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors())
            );
        }
        break;

    case 'editPartner':
        $moduleAdmin->displayNavigation('main.php');
        $id = (int)$id > XoopspartnersConstants::DEFAULT_PID ? (int)$id : XoopspartnersConstants::DEFAULT_PID;

        $xpPartnersHandler = $xpHelper->getHandler('partners');
        $partnerObj        = $xpPartnersHandler->get($id);
        if (!empty($partnerObj) && ($partnerObj instanceof XoopspartnersPartners)) {
            $partnerVars = $partnerObj->getValues();
            /*url, image, title, and description are all txtboxes so they have gone through
             * htmlspecialchars via XoopsObject getVar
             */
            include $GLOBALS['xoops']->path('/class/xoopsformloader.php');
            $form       = new XoopsThemeForm(_AM_XPARTNERS_EDITPARTNER, 'editform', 'main.php', 'post', true);
            $formWeight = new XoopsFormText(_AM_XPARTNERS_WEIGHT, 'weight', 3, 10, $partnerVars['weight']);
            $formHits   = new XoopsFormText(_AM_XPARTNERS_HITS, 'hits', 3, 10, $partnerVars['hits']);
            $formImage  = new XoopsFormText(_AM_XPARTNERS_IMAGE, 'image', 50, 150, $partnerVars['image']);
            $formUrl    = new XoopsFormText(_AM_XPARTNERS_URL, 'url', 50, 150, $partnerVars['url']);
            $formTitle  = new XoopsFormText(_AM_XPARTNERS_TITLE, 'title', 50, 50, $partnerVars['title']);
            $formDesc   = new XoopsFormTextArea(_AM_XPARTNERS_DESCRIPTION,
                                                'description',
                                                $partnerVars['description'],
                                                5,
                                                51
            );
            $statOnTxt  = "<img src='" . Admin::iconUrl('on.png', '16') . "' "
                        .   "class='tooltip floatcenter1' "
                        .   "alt='" . _AM_XPARTNERS_ACTIVE . "'>"
                        .  _AM_XPARTNERS_ACTIVE;
            $statOffTxt = "<img src='" . Admin::iconUrl('off.png', '16') . "' "
                        .   "class='tooltip floatcenter1' "
                        .   "alt='" . _AM_XPARTNERS_INACTIVE . "'>"
                        .  _AM_XPARTNERS_INACTIVE;
            $formStat   = new XoopsFormRadioYN(_AM_XPARTNERS_STATUS,
                                               'status',
                                               $partnerVars['status'],
                                               $statOnTxt,
                                               $statOffTxt
            );

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
            $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_INVALIDID);
        }
        break;

    case 'updatePartner':
        $title       = trim($title);
        $image       = trim($image);
        $image       = $myts->addSlashes(formatURL($image));
        $url         = trim($url);
        $description = trim($description);
        $id          = ($id > XoopspartnersConstants::DEFAULT_PID) ? $id : XoopspartnersConstants::DEFAULT_PID;
        $status      = (!empty($status) && ($status > XoopspartnersConstants::STATUS_INACTIVE))
                        ? (int)$status
                        : XoopspartnersConstants::STATUS_INACTIVE;
        $weight      = Request::getInt('weight', XoopspartnersConstants::DEFAULT_WEIGHT, 'POST');
        $weight      = $weight > XoopspartnersConstants::DEFAULT_WEIGHT
                       ? $weight
                       : XoopspartnersConstants::DEFAULT_WEIGHT;
        $hits        = $hits > 0 ? $hits : 0;
        if (empty($title) || empty($url) || empty($id) || empty($description)) {
            $xpHelper->url("admin/main.php?op=edit_partner&amp;id={$id}",
                            XoopspartnersConstants::REDIRECT_DELAY_SHORT,
                            _AM_XPARTNERS_BESURE
            );
        }

        $xpPartnersHandler = $xpHelper->getHandler('partners');
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
                $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
            }
        }
        $xpHelper->url('admin/main.php',
                        XoopspartnersConstants::REDIRECT_DELAY_MEDIUM,
                        _AM_XPARTNERS_NOTUPDATED . '<br>' . implode('<br>',
                        $GLOBALS['xoopsSecurity']->getErrors())
        );
        break;

    case 'delPartner':
        if ((XoopspartnersConstants::CONFIRM_OK === $del) && ($id > XoopspartnersConstants::DEFAULT_PID)) {
            $xpPartnersHandler = $xpHelper->getHandler('partners');
            $partnerObj        = $xpPartnersHandler->get($id);
            if ($partnerObj instanceof XoopspartnersPartners) {
                if ($xpPartnersHandler->delete($partnerObj)) {
                    $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_SHORT, _AM_XPARTNERS_UPDATED);
                }
            }
            $xpHelper->url('admin/main.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _AM_XPARTNERS_NOTUPDATED);
        } else {
            $moduleAdmin->displayNavigation('main.php');
            xoops_confirm(array('op'  => 'delPartner',
                                'id'  => (int)$id,
                                'del' => XoopspartnersConstants::CONFIRM_OK),
                          'main.php',
                          _AM_XPARTNERS_SUREDELETE
            );
            include __DIR__ . '/admin_footer.php';
        }
        break;
}
