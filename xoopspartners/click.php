<?php
/**
 * Click page for the Xoops Partners Module
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
 * @version     $Id: click.php 9326 2012-04-14 21:53:58Z beckmi $
 * @since       2.3.0
 */
 
// Include header
include_once 'header.php';

$partners_handler = &xoops_getModuleHandler( 'partners' );

$id = xoopsPartners_CleanVars( $_REQUEST, 'id', 0, 'int' );

if ( !isset($_COOKIE['partners'.$id]) ) {
    setcookie('partners' . $id, $id, time() + xoopsPartners_setting('cookietime'));
    $partners_handler->setHits($id);
}
// Include footer
include_once 'footer.php';
