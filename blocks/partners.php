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
 * @category     Module
 * @package      xoopspartners
 * @subpackage   admin
 * @author       ::     Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */

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
    $myts = MyTextSanitizer::getInstance();

    $block          = array();
    $moduleDirname  = basename(dirname(__DIR__));
    $block['xpDir'] = $moduleDirname;

    $partnerHandler = xoops_getModuleHandler('partners', $moduleDirname);
    $pFields         = array('id', 'url', 'image', 'title', 'description');
    $criteria        = new CriteriaCompo();
    $criteria->setLimit($options[3]);
    if ($options[2]) {
        $criteria->setSort('RAND()');
    } else {
        $criteria->setSort($options[5]);
        $criteria->setOrder($options[6]);
    }
    $pObjs = $partnerHandler->getAll($criteria, $pFields);
    foreach ($pObjs as $pObj) {
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

    //now load the stylesheet
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . "/modules/{$moduleDirname}/assets/css/style.css");

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
        $chk0no  = " checked='checked'";
        $chk0yes = '';
    } else {
        $chk0no  = '';
        $chk0yes = " checked='checked'";
    }
    if (0 == $options[1]) { //fade partners in/out
        $chk1no  = " checked='checked'";
        $chk1yes = '';
    } else {
        $chk1no  = '';
        $chk1yes = " checked='checked'";
    }
    if (0 == $options[2]) {  //randomize partners in block
        $chk2no  = " checked='checked'";
        $chk2yes = '';
    } else {
        $chk2no  = '';
        $chk2yes = " checked='checked'";
    }
    $form =
        "<table style='border-width: 0px;'>\n" . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_PSPACE . "</td>\n" . '    <td>' . "<input type='radio' name='options[0]' value='0'{$chk0no}>" . _NO . '' . "<input type='radio' name='options[0]' value='1'{$chk0yes}>" . _YES . '' . "    </td>\n" . "  </tr>\n"
        . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_FADE . "</td>\n" . '    <td>' . "<input type='radio' name='options[1]' value='0'{$chk1no}>" . _NO . '' . "<input type='radio' name='options[1]' value='1'{$chk1yes}>" . _YES . "</td>\n" . "  </tr>\n" . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_BRAND
        . "</td>\n" . '     <td>' . "<input type='radio' name='options[2]' value='0'{$chk2no}>" . _NO . '' . "<input type='radio' name='options[2]' value='1'{$chk2yes}>" . _YES . "</td>\n" . "  </tr>\n" . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_BLIMIT . "</td>\n"
        . "    <td><input class='txtright' type='number' name='options[3]' size='5' value='{$options[3]}' min='0'></td>\n" . "  </tr>\n" . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_BSHOW . "</td>\n" . "    <td>\n" . "      <select size='1' name='options[4]'>\n";
    $sel  = (1 == $options[4]) ? " selected='selected'" : '';
    $form .= "        <option value='1'{$sel}>" . _MB_XPARTNERS_IMAGES . "</option>\n";

    $sel = (2 == $options[4]) ? " selected='selected'" : '';
    $form .= "        <option value='2'{$sel}>" . _MB_XPARTNERS_TEXT . "</option>\n";

    $sel = (3 == $options[4]) ? " selected='selected'" : '';
    $form .= "        <option value='3'{$sel}>" . _MB_XPARTNERS_BOTH . "</option>\n" . "      </select>\n" . "    </td>\n" . "  </tr>\n" . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_BSORT . "</td>\n" . "    <td>\n" . "      <select size='1' name='options[5]'>";
    $sel = ('id' === $options[5]) ? " selected='selected'" : '';
    $form .= "        <option value='id'{$sel}>" . _MB_XPARTNERS_ID . "</option>\n";

    $sel = ('hits' === $options[5]) ? " selected='selected'" : '';
    $form .= "        <option value='hits'{$sel}>" . _MB_XPARTNERS_HITS . "</option>\n";

    $sel = ('title' === $options[5]) ? " selected='selected'" : '';
    $form .= "        <option value='title'{$sel}>" . _MB_XPARTNERS_TITLE . "</option>\n";

    $sel = ('weight' === $options[5]) ? " selected='selected'" : '';
    $form .= "        <option value='weight'{$sel}>" . _MB_XPARTNERS_WEIGHT . "</option>\n" . "      </select>\n" . "      <select size='1' name='options[6]'>\n";

    $sel = ('ASC' === $options[6]) ? " selected='selected'" : '';
    $form .= "        <option value='ASC'{$sel}>" . _MB_XPARTNERS_ASC . "</option>\n";

    $sel = ('DESC' === $options[6]) ? " selected='selected'" : '';
    $form .= "        <option value='DESC'{$sel}>" . _MB_XPARTNERS_DESC . "</option>\n" . "      </select>\n" . "    </td>\n" . "  </tr>\n" . "  <tr>\n" . '    <td>' . _MB_XPARTNERS_TTL_LENGTH . "</td>\n"
             . "    <td><input type='number' class='txtright' name='options[7]' size='5' value='{$options[7]}' min='0'></td>\n" . "  </tr>\n" . "  <tr>\n" . "</table>\n";
    return $form;
}
