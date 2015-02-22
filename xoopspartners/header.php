<?php
/**
 * Header for the Xoops Partners Module
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id: header.php 9326 2012-04-14 21:53:58Z beckmi $
 * @since       2.3.0
 */

include dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'mainfile.php';

require_once XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/include/functions.php';
// Xoops Class
xoops_load('xoopsformloader');
xoops_load('template');
// Admin language
xoops_loadLanguage('admin', $xoopsModule->getVar( 'dirname' ));

?>