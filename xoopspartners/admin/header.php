<?php
/**
 * Admin header for the Xoops Partners Module
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
 * @version     $Id: header.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */
include dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/include/cp_header.php';
// Xoops Class
xoops_load('xoopsformloader');
xoops_load('template');
xoops_loadLanguage('modinfo', $xoopsModule->getVar( 'dirname' ));
// Includes
require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar( 'dirname' ) . '/include/functions.php';
// Get menu tab handler
$menu_handler = &xoops_getmodulehandler( 'menu' );
// Define top navigation
$menu_handler->addMenuTop( XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar( 'mid' ), _PREFERENCES );
$menu_handler->addMenuTop( XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=' . $xoopsModule->getVar( 'dirname' ), _XO_MI_MENU_MODULEUPDATE );
$menu_handler->addMenuTop( XOOPS_URL . '/modules/' . $xoopsModule->getVar( 'dirname' ) . '/', _XO_MI_MENU_MODULEHOME );
// Define main tab navigation
foreach ( $xoopsModule->getAdminMenu() as $menu ) {
  $menu_handler->addMenuTabs( $menu['link'], $menu['title'] );
}
