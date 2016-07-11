<?php
/*
 *  ------------------------------------------------------------------------
 *                XOOPS - PHP Content Management System
 *                    Copyright (c) 2000 XOOPS.org
 *                       <http://www.xoops.org/>
 *  ------------------------------------------------------------------------
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 * -------------------------------------------------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 * -------------------------------------------------------------------------
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
/** @var string $xoopsOption */
$xoopsOption['template_main'] = 'xoopspartners_join.tpl';
include $GLOBALS['xoops']->path('/header.php');
$myts = MyTextSanitizer::getInstance();

$op = XoopsRequest::getCmd('op', '', 'POST');

if (!$GLOBALS['xoopsUser'] instanceof XoopsUser) {
    redirect_header('index.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _NOPERM);
}

if ('sendMail' === $op) {
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('index.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _MD_XPARTNERS_ERROR1 . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }
    //Changed - don't extract $_POST vars directly into var table space
    //extract($_POST);
    extract($_POST, EXTR_PREFIX_ALL, 'unsafe');
    if (empty($unsafe_title) || empty($unsafe_description) || empty($unsafe_url) || $unsafe_url === 'http://') {
        $GLOBALS['xoopsTpl']->assign(array(
                                         'content4join'      => _MD_XPARTNERS_ERROR1,
                                         'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
                                         'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                                     ));
        //        $xoopsContentsTpl = 'xoopspartners_join.tpl';
        include_once __DIR__ . '/footer.php';
        exit();
    }
    include $GLOBALS['xoops']->path('/class/xoopsmailer.php');
    $url         = formatURL($myts->htmlSpecialChars($unsafe_url));
    $title       = $myts->htmlSpecialChars($unsafe_title);
    $description = $myts->htmlSpecialChars($unsafe_description);
    $image       = formatURL($myts->htmlSpecialChars($unsafe_image));
    $image       = xoops_trim($image);
    $image       = (('http://' === $image) || ('https://' === $image)) ? '' : $image;
    if (!empty($image)) {
        $allowed_mimetypes = array(
            'gif'  => 'image/gif',
            'jpg'  => 'image/jpeg',
            'pjpe' => 'image/pjpeg',  //IE7
            'png'  => 'image/png',
            'xpng' => 'image/x-png',  //IE7
            //                           'bmp' => 'image/bmp',
            //                          'tiff' => 'image/tiff',
            //                           'tif' => 'image/tif',
        );
        $maxfilesize       = ((int)$GLOBALS['xoopsModule']->getInfo('maxuploadsize') > 0) ? $GLOBALS['xoopsModule']->getInfo('maxuploadsize') : XoopspartnersConstants::DEFAULT_UPLOAD_SIZE;
        $maxfilewidth      = ((int)$GLOBALS['xoopsModule']->getInfo('maxwidth') > 0) ? $GLOBALS['xoopsModule']->getInfo('maxwidth') : XoopspartnersConstants::DEFAULT_MAX_WIDTH;
        $maxfileheight     = ((int)$GLOBALS['xoopsModule']->getInfo('maxheight') > 0) ? $GLOBALS['xoopsModule']->getInfo('maxheight') : XoopspartnersConstants::DEFAULT_MAX_HEIGHT;
        if (preg_match('^http:\/\/|https:\/\/[^\s]', $image)) {
            // image is from external source
            XoopsLoad::load('xoopsmediauploader');
            $uploader = new XoopsMediaUploader($GLOBALS['xoops']->path('/uploads/xoopspartners'), $allowed_mimetypes, $maxfilesize);
            if ($uploader->fetchMedia($image)) {
                if ($uploader->upload()) {
                    //        echo "<h4>File uploaded successfully!</h4>\n";
                    $image = $uploader->getSavedFileName();  // get file name to save in db
                    //        echo 'Full path: ' . $uploader->getSavedDestination();
                }
            }
        }

        $imageInfo  = @getimagesize($image);
        $uploadErrs = ($uploader instanceof XoopsMediaUploader) ? $uploader->getErrors() : '';
        if (false == $imageInfo || !empty($uploadErrs)) { // could not find image
            $GLOBALS['xoopsTpl']->assign(array(
                                             'content4join'      => sprintf(_MD_XPARTNERS_ERROR3, $image) . '<br>' . $uploader->getErrors(),
                                             'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
                                             'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                                         ));
            //            $xoopsContentsTpl = 'xoopspartners_join.tpl';
            include_once __DIR__ . '/footer.php';
            exit();
        }
    }
    $xoopsMailer =& xoops_getMailer();
    $xoopsMailer->useMail();
    $xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/' . $GLOBALS['xoopsModule']->getVar('dirname', 'n') . "/language/{$GLOBALS['xoopsConfig']['language']}/mail_template/"));
    $xoopsMailer->setTemplate('join.tpl');
    $xoopsMailer->assign(array(
                             'SITENAME'    => $GLOBALS['xoopsConfig']['sitename'],
                             'SITEURL'     => $GLOBALS['xoops']->url('www'),
                             'IP'          => $_SERVER['REMOTE_ADDR'],
                             'URL'         => $url,
                             'IMAGE'       => $image,
                             'TITLE'       => $title,
                             'DESCRIPTION' => $description,
                             'USER'        => $GLOBALS['xoopsUser']->getVar('uname'),
                             'MODULENAME'  => $GLOBALS['xoopsModule']->getVar('dirname')
                         ));
    $xoopsMailer->setToEmails($GLOBALS['xoopsConfig']['adminmail']);
    $xoopsMailer->setFromEmail($GLOBALS['xoopsUser']->getVar('email'));
    $xoopsMailer->setFromName($GLOBALS['xoopsUser']->getVar('uname'));
    $xoopsMailer->setSubject(sprintf(_MD_XPARTNERS_NEWPARTNER, $GLOBALS['xoopsConfig']['sitename']));
    if (!$xoopsMailer->send()) {
        $GLOBALS['xoopsTpl']->assign(array(
                                         'content4join'      => '<br>' . $xoopsMailer->getErrors() . _MD_XPARTNERS_GOBACK,
                                         'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
                                         'lang_join'         => _MD_XPARTNERS_JOIN,
                                         'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                                     ));
    } else {
        $GLOBALS['xoopsTpl']->assign(array(
                                         'content4join'      => '<br>' . _MD_XPARTNERS_SENDMAIL,
                                         'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
                                         'lang_join'         => _MD_XPARTNERS_JOIN,
                                         'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                                     ));
    }
    //    $xoopsContentsTpl = 'xoopspartners_join.tpl';
} else {
    include $GLOBALS['xoops']->path('/class/xoopsformloader.php');
    $form = new XoopsThemeForm('', 'joinform', 'join.php', 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
    $titlePartner       = new XoopsFormText(_MD_XPARTNERS_TITLE, 'title', 100, 150);
    $imagePartner       = new XoopsFormText(_MD_XPARTNERS_IMAGE, 'image', 100, 150, 'http://');
    $urlPartner         = new XoopsFormText(_MD_XPARTNERS_URL, 'url', 100, 150, 'http://');
    $descriptionPartner = new XoopsFormTextArea(_MD_XPARTNERS_DESCRIPTION, 'description', '', 7, 50);
    $op_hidden          = new XoopsFormHidden('op', 'sendMail');
    $submitButton       = new XoopsFormButton('', 'dbsubmit', _MD_XPARTNERS_SEND, 'submit');
    $form->addElement($titlePartner, true);
    $form->addElement($imagePartner);
    $form->addElement($urlPartner, true);
    $form->addElement($descriptionPartner, true);
    $form->addElement($op_hidden);
    $form->addElement($submitButton);
    $content = $form->render();
    $GLOBALS['xoopsTpl']->assign(array(
                                     'content4join'      => $content,
                                     'lang_main_partner' => _MD_XPARTNERS_PARTNERS,
                                     'lang_join'         => _MD_XPARTNERS_JOIN,
                                     'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                                 ));
}

include_once __DIR__ . '/footer.php';
