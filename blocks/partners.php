<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *-----------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 *-----------------------------------
 */
/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\blocks
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */
use Xmf\Module\Helper;

/**
 *
 * Show partners in block
 * @param array $options from block preferences
 *
 *  $options:  0  - Put spaces between partners
 *             1  - Fade partners in/out
 *             2  - Randomize which partners to display in block
 *             3  - Number of partners to display
 *             4  - show images|text|both
 *             5  - display order id|hits|title|weight
 *             6  - order ASC|DESC
 *             7  - max title length (0 for unlimited)
 *
 * @return array block settings
 */
function b_xoopspartners_show($options)
{
    $myts = \MyTextSanitizer::getInstance();

    $moduleDirName     = basename(dirname(__DIR__));
    $xpHelper          = Helper::getHelper($moduleDirName);
    $xpPartnersHandler = $xpHelper->getHandler('partners');

    $block             = ['xpDir' => $moduleDirName];

    $pFields         = ['id', 'url', 'image', 'title', 'description'];
    $criteria        = new \CriteriaCompo(new \Criteria('status', 1, '='));
    $criteria->setLimit($options[3]);
    if ($options[2]) {
        $criteria->setSort('RAND()');
    } else {
        $criteria->setSort($options[5]);
        $criteria->setOrder($options[6]);
    }
    $pObjs = $xpPartnersHandler->getAll($criteria, $pFields);
    foreach ($pObjs as $pObj) {
        $partners    = [];
        $url         = $pObj->getVar('url');
        $origtitle   = $pObj->getVar('title');
        $title       = $origtitle;
        $description = $pObj->getVar('description');
        $image       = $pObj->getVar('image');
        //@TODO:  make display string length a config option
        if (!empty($options[7])) {
            $title = xoops_substr($origtitle, 0, (int)$options[7]);
        }

        //        $title = (mb_strlen($origtitle) > 19) ? xoops_substr($title, 0, 19) : $title;
        $partners['id']          = $pObj->getVar('id');
        $partners['url']         = $url;
        $partners['description'] = $description;

        if (!empty($image) && (1 == $options[4] || 3 == $options[4])) {
            $partners['image'] = $image;
            $partners['image_ttl'] = $title;
        }
        if (empty($image) || (2 == $options[4]) || (3 == $options[4])) {
            $partners['title'] = $title;
        } else {
            $partners['title'] = '';
        }
        $block['partners'][] = $partners;
    }
    $block['insertBr']  = (1 == $options[0]);
    $block['fadeImage'] = (1 == $options[1]) ;

    //now load the stylesheet & jquery
    $GLOBALS['xoTheme']->addStylesheet($xpHelper->url('assets/css/style.css'));
    $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
    $GLOBALS['xoTheme']->renderMetas(null, true);

    return $block;
}

/**
 *
 * Edit Random Partners block preferences
 *
 * @param array $options from block preferences
 *
 * @return string HTML to display for edit form
 */
function b_xoopspartners_edit($options)
{
    if (0 == $options[0]) { //put spaces between partners
        $chk0no  = ' checked';
        $chk0yes = '';
    } else {
        $chk0no  = '';
        $chk0yes = ' checked';
    }
    if (0 == $options[1]) { //fade partners in/out
        $chk1no  = ' checked';
        $chk1yes = '';
    } else {
        $chk1no  = '';
        $chk1yes = ' checked';
    }
    if (0 == $options[2]) {  //randomize partners in block
        $chk2no  = ' checked';
        $chk2yes = '';
    } else {
        $chk2no  = '';
        $chk2yes = ' checked';
    }
    $form = "<table class='bnone'>\n"
        . "  <tr>\n"
            . '    <td>' . _MB_XOOPSPARTNERS_PSPACE . "</td>\n"
            . '    <td>'
        .        "<input type='radio' name='options[0]' id ='options0_0' value='0'{$chk0no}>"
        .        "<label for='options0_0'>" . _NO . '</label>&nbsp;'
        .        "<input type='radio' name='options[0]' id ='options0_1' value='1'{$chk0yes}>"
        .        "<label for='options0_1'>" . _YES . '</label>'
        .      "</td>\n"
        . "  </tr>\n"
        . "  <tr>\n"
            . '    <td>' . _MB_XOOPSPARTNERS_FADE . "</td>\n"
            . '    <td>'
        .        "<input type='radio' name='options[1]' id='options1_0' value='0'{$chk1no}>" . _NO
        .        "<label for='options1_0'>" . _NO . '</label>&nbsp;'
        .        "<input type='radio' name='options[1]' id='options1_1' value='1'{$chk1yes}>" . _YES
        .        "<label for='options1_1'>" . _YES . '</label>'
        .      "</td>\n"
        . "  </tr>\n"
        . "  <tr>\n"
            . '    <td>' . _MB_XOOPSPARTNERS_BRAND . "</td>\n"
            . '     <td>'
        .         "<input type='radio' name='options[2]' id='option2_0' value='0'{$chk2no}>" . _NO
        .         "<label for='options2_0'>" . _NO . '</label>'
        .         "<input type='radio' name='options[2]' id='options2_1' value='1'{$chk2yes}>" . _YES
        .         "<label for='options2_1'>" . _YES . '</label>'
        .       "</td>\n"
        . "  </tr>\n"
        . "  <tr>\n"
            . '    <td>' . _MB_XOOPSPARTNERS_BLIMIT . "</td>\n"
        . "    <td><input class='right' type='number' name='options[3]' size='5' value='{$options[3]}' min='0'></td>\n"
        . "  </tr>\n"
        . "  <tr>\n"
        . '    <td>' . _MB_XOOPSPARTNERS_BSHOW . "</td>\n"
        . "    <td>\n"
        . "      <select size='1' name='options[4]'>\n";
    $sel  = (1 == $options[4]) ? ' selected' : '';
    $form .= "        <option value='1'{$sel}>" . _MB_XOOPSPARTNERS_IMAGES . "</option>\n";

    $sel = (2 == $options[4]) ? ' selected' : '';
    $form .= "        <option value='2'{$sel}>" . _MB_XOOPSPARTNERS_TEXT . "</option>\n";

    $sel = (3 == $options[4]) ? ' selected' : '';
    $form .= "        <option value='3'{$sel}>" . _MB_XOOPSPARTNERS_BOTH . "</option>\n"
           . "      </select>\n"
           . "    </td>\n"
           . "  </tr>\n"
           . "  <tr>\n"
             . '    <td>' . _MB_XOOPSPARTNERS_BSORT . "</td>\n"
           . "    <td>\n"
           . "      <select size='1' name='options[5]'>\n";

    $sel = ('id' === $options[5]) ? ' selected' : '';
    $form .= "        <option value='id'{$sel}>" . _MB_XOOPSPARTNERS_ID . "</option>\n";

    $sel = ('hits' === $options[5]) ? ' selected' : '';
    $form .= "        <option value='hits'{$sel}>" . _MB_XOOPSPARTNERS_HITS . "</option>\n";

    $sel = ('title' === $options[5]) ? ' selected' : '';
    $form .= "        <option value='title'{$sel}>" . _MB_XOOPSPARTNERS_TITLE . "</option>\n";

    $sel = ('weight' === $options[5]) ? ' selected' : '';
    $form .= "        <option value='weight'{$sel}>" . _MB_XOOPSPARTNERS_WEIGHT . "</option>\n"
           . "      </select>\n"
           . "      <select size='1' name='options[6]'>\n";

    $sel = ('ASC' === $options[6]) ? ' selected' : '';
    $form .= "        <option value='ASC'{$sel}>" . _MB_XOOPSPARTNERS_ASC . "</option>\n";

    $sel = ('DESC' === $options[6]) ? ' selected' : '';
    $form .= "        <option value='DESC'{$sel}>" . _MB_XOOPSPARTNERS_DESC . "</option>\n"
           . "      </select>\n"
           . "    </td>\n"
           . "  </tr>\n"
           . "  <tr>\n"
           . '    <td>' . _MB_XOOPSPARTNERS_TTL_LENGTH . "</td>\n"
             . '    <td>'
           .        "<input type='number' class='right' name='options[7]' size='5' value='{$options[7]}' min='0'>"
           .      "</td>\n"
           . "  </tr>\n"
           . "  <tr>\n"
           . "</table>\n";
    return $form;
}
