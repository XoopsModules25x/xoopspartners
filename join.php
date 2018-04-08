<?php
/*
 *  You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
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
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */
use Xmf\Request;
use Xmf\Module\Helper;

require __DIR__ . '/header.php';
if (!isset($GLOBALS['xoopsUser']) || !$GLOBALS['xoopsUser'] instanceof \XoopsUser) {
    $xpHelper->redirect('index.php', XoopspartnersConstants::REDIRECT_DELAY_MEDIUM, _NOPERM);
}

/** @var string $xoopsOption */
$GLOBALS['xoopsOption']['template_main'] = 'xoopspartners_join.tpl';
include $GLOBALS['xoops']->path('/header.php');

$op     = Request::getCmd('op', '', 'POST');
$myts   = \MyTextSanitizer::getInstance();
$xpInfo = $xpHelper->getModule()->getInfo();

switch ($op) {
    case 'sendMail':
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $xpHelper->redirect(
                'index.php',
                            XoopspartnersConstants::REDIRECT_DELAY_MEDIUM,
                            _MD_XOOPSPARTNERS_ERROR1 . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors())
            );
    }
    extract($_POST, EXTR_PREFIX_ALL, 'unsafe');
    if (empty($unsafe_title) || empty($unsafe_description) || empty($unsafe_url) || 'http://' === $unsafe_url) {
        $GLOBALS['xoopsTpl']->assign(
            [
                                         'content4join'      => _MD_XOOPSPARTNERS_ERROR1,
                                         'lang_main_partner' => _MD_XOOPSPARTNERS_PARTNERS,
                                         'sitename'          => $GLOBALS['xoopsConfig']['sitename']
            ]
            );
    } else {
        $url         = formatURL($myts->htmlSpecialChars($unsafe_url));
        $title       = $myts->htmlSpecialChars($unsafe_title);
        $description = $myts->htmlSpecialChars($unsafe_description);
        $image       = formatURL($myts->htmlSpecialChars($unsafe_image));
        $image       = xoops_trim($image);
        $image       = (('http://' === $image) || ('https://' === $image)) ? '' : $image;
        if (!empty($image)) {
            $allowed_mimetypes = [
            'gif'  => 'image/gif',
            'jpg'  => 'image/jpeg',
            'pjpe' => 'image/pjpeg',  //IE7
            'png'  => 'image/png',
            'xpng' => 'image/x-png',  //IE7
            //                           'bmp' => 'image/bmp',
            //                          'tiff' => 'image/tiff',
            //                           'tif' => 'image/tif',
            ];
            $maxFileSize   = (int)$xpInfo['maxuploadsize'] > 0
                               ? (int)$xpInfo['maxuploadsize']
                               : XoopspartnersConstants::DEFAULT_UPLOAD_SIZE;
            /*                $maxFileWidth  = (int)$xpInfo['maxwidth'] > 0
                                             ? (int)$xpInfo['maxwidth']
                                             : XoopspartnersConstants::DEFAULT_MAX_WIDTH; */
            /*                $maxFileHeight = (int)$xpInfo['maxheight'] > 0
                                             ? (int)$xpInfo('maxheight')
                                             : XoopspartnersConstants::DEFAULT_MAX_HEIGHT; */
            if (preg_match('^http[s]?:\/\/[^\s]', $image)) {
                // image is from external source
                xoops_load('xoopsmediauploader');
                $uploader = new \XoopsMediaUploader(
                        XOOPS_UPLOAD_PATH . "/{$moduleDirName}",
                                                       $allowed_mimetypes,
                                                       $maxFileSize
                    );
                if ($uploader->fetchMedia($image)) {
                    if ($uploader->upload()) {
                        $image = $uploader->getSavedFileName();  // get file name to save in db
                    }
                }
            }

            $imageInfo  = @getimagesize($image);
            $uploadErrs = ($uploader instanceof XoopsMediaUploader) ? $uploader->getErrors() : '';
            if (false === $imageInfo || !empty($uploadErrs)) { // could not find image
                $GLOBALS['xoopsTpl']->assign(
                    [
                                                     'content4join'      => sprintf(_MD_XOOPSPARTNERS_ERROR3, $image)
                                                                            . '<br>' . $uploader->getErrors(),
                                             'lang_main_partner' => _MD_XOOPSPARTNERS_PARTNERS,
                                             'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                    ]
                    );
                require_once __DIR__ . '/footer.php';
                exit();
            }
        }
        $xoopsMailer = xoops_getMailer();
        $xoopsMailer->useMail();
        $tplPath = 'language/%s/mail_template/';
        if (file_exists($xpHelper->path(sprintf($tplPath, $GLOBALS['xoopsConfig']['language'])))) {
            $xoopsMailer->setTemplateDir($xpHelper->path(sprintf($tplPath, $GLOBALS['xoopsConfig']['language'])));
        } else {
            $xoopsMailer->setTemplateDir($xpHelper->path(sprintf($tplPath, 'english')));
        }
        $xoopsMailer->setTemplate('join.tpl');
        $xoopsMailer->assign(
            [
                             'SITENAME'    => $GLOBALS['xoopsConfig']['sitename'],
                             'SITEURL'     => $GLOBALS['xoops']->url('www'),
                             'IP'          => $_SERVER['REMOTE_ADDR'],
                             'URL'         => $url,
                             'IMAGE'       => $image,
                             'TITLE'       => $title,
                             'DESCRIPTION' => $description,
                             'USER'        => $GLOBALS['xoopsUser']->getVar('uname'),
                                    'MODULENAME'  => $moduleDirName
            ]
            );
        $xoopsMailer->setToEmails($GLOBALS['xoopsConfig']['adminmail']);
        $xoopsMailer->setFromEmail($GLOBALS['xoopsUser']->getVar('email'));
        $xoopsMailer->setFromName($GLOBALS['xoopsUser']->getVar('uname'));
        $xoopsMailer->setSubject(sprintf(_MD_XOOPSPARTNERS_NEWPARTNER, $GLOBALS['xoopsConfig']['sitename']));
        if (!$xoopsMailer->send()) {
            $GLOBALS['xoopsTpl']->assign(
                [
                                                 'content4join'      => '<br>'
                                                                        . $xoopsMailer->getErrors()
                                                                        . _MD_XOOPSPARTNERS_GOBACK,
                                         'lang_main_partner' => _MD_XOOPSPARTNERS_PARTNERS,
                                         'lang_join'         => _MD_XOOPSPARTNERS_JOIN,
                                         'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                ]
                );
        } else {
            $GLOBALS['xoopsTpl']->assign(
                [
                                                 'content4join'      => '<br>'
                                                                        . _MD_XOOPSPARTNERS_SENDMAIL,
                                         'lang_main_partner' => _MD_XOOPSPARTNERS_PARTNERS,
                                         'lang_join'         => _MD_XOOPSPARTNERS_JOIN,
                                         'sitename'          => $GLOBALS['xoopsConfig']['sitename']
                ]
                );
        }
    }
        break;
    default:
    include $GLOBALS['xoops']->path('/class/xoopsformloader.php');
    $form = new \XoopsThemeForm('', 'joinform', 'join.php', 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
        $titlePartner = new \XoopsFormText(_MD_XOOPSPARTNERS_TITLE, 'title', 50, 50);
        $imagePartner = new \XoopsFormText(_MD_XOOPSPARTNERS_IMAGE, 'image', 50, 150, 'http://');
        $urlPartner   = new \XoopsFormText(_MD_XOOPSPARTNERS_URL, 'url', 50, 150, 'http://');
        $descrPartner = new \XoopsFormTextArea(_MD_XOOPSPARTNERS_DESCRIPTION, 'description', '', 5, 51);
        $opHidden     = new \XoopsFormHidden('op', 'sendMail');
    $submitButton       = new \XoopsFormButton('', 'dbsubmit', _MD_XOOPSPARTNERS_SUBMIT, 'submit');
    $form->addElement($titlePartner, true);
    $form->addElement($imagePartner);
    $form->addElement($urlPartner, true);
        $form->addElement($descrPartner, true);
        /* @todo add captcha to join form */
//        $form->addElement(new \XoopsFormCaptcha());
        $form->addElement($opHidden);
    $form->addElement($submitButton);
    $content = $form->render();
    $GLOBALS['xoopsTpl']->assign(
        [
                                     'content4join'      => $content,
                                     'lang_main_partner' => _MD_XOOPSPARTNERS_PARTNERS,
                                     'lang_join'         => _MD_XOOPSPARTNERS_JOIN,
                                     'sitename'          => $GLOBALS['xoopsConfig']['sitename']
        ]
        );
}

require_once __DIR__ . '/footer.php';
