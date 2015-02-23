<?php
/**
 * Menu for the Xoops Partners Module
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
 * @version     $Id: menu.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );
/**
 * Admin Menus
 */
$adminmenu[] = array( 'title' => _XO_MI_MENU_ADMININDEX, 'link' => 'admin/index.php' );
$adminmenu[] = array( 'title' => _XO_MI_MENU_ADMINPARTNERS, 'link' => 'admin/partners.php?op=add&amp;type=partners' );

?>