<?php
/**
 * Admin Partners managment for Xoops Partners
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
 * @version     $Id: partners.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */

// Include header
include 'header.php';
// Get default variables
$op = xoopsPartners_CleanVars( $_REQUEST, 'op', 'add', 'string' );
$type = xoopsPartners_CleanVars( $_REQUEST, 'type', 'partners', 'string' );
// Display Xoops header
xoops_cp_header();
// Change form
if( !isset($_POST['post']) && isset($_POST['formtype']) ){
    // Diplay navigation menu
    $menu_handler->render( 1 );
    // Redirect to other type
    xoopsPartners_redirect('partners.php?op=add&amp;type=' . $_POST['formtype'], 0, _XO_AD_WAIT_MESSAGE);
    // Include footer
    xoops_cp_footer();
    // Quit procedure
    exit;
}
// Load Partner/Category Handler
$partners_handler = &xoops_getModuleHandler( $type );
// Retreive form data for all case
switch ($op) {
    case 'add': // Add Partner/Category
        // Diplay navigation menu
        $menu_handler->render( 1 );
        $obj = $partners_handler->create();
        $obj->displayAdminForm();
        break;

    case 'edit': // Edit Partner/Category
        // Diplay navigation menu
        $menu_handler->render( 1 );
        $id = xoopsPartners_CleanVars( $_REQUEST, 'id', 0, 'int' );
        $obj = $partners_handler->get($id);
        $obj->displayAdminForm($op);
        break;

    case 'save':
        if ( !$GLOBALS['xoopsSecurity']->check() ) {
            redirect_header( 'index.php', 0, $GLOBALS['xoopsSecurity']->getErrors( true ) );
        }
        // Diplay navigation menu
        $menu_handler->render( 1 );
        $id = xoopsPartners_CleanVars( $_REQUEST, $partners_handler->keyName, 0, 'int' );
        $obj = ( $id == 0 ) ? $partners_handler->create() : $partners_handler->get( $id );
        if ( is_object( $obj ) ) {
            $obj->setVars( $_REQUEST );
            $obj->setVar( 'dohtml', isset( $_REQUEST['dohtml'] ) ? 1 : 0 );
            $obj->setVar( 'dosmiley', isset( $_REQUEST['dosmiley'] ) ? 1 : 0 );
            $obj->setVar( 'doxcode', isset( $_REQUEST['doxcode'] ) ? 1 : 0 );
            $obj->setVar( 'doimage', isset( $_REQUEST['doimage'] ) ? 1 : 0 );
            $obj->setVar( 'dobr', isset( $_REQUEST['dobr'] ) ? 1 : 0 );
            $ret = $partners_handler->insert( $obj, true );
            if ( $ret ) {
                xoopsPartners_redirect( 'index.php', 1, _XO_AD_DBSUCCESS );
                // Display Xoops footer
                xoops_cp_footer();
                exit;
            }
        }
        // Display Error
        xoops_error( $ret, _XO_AD_PARTNER_SUBERROR );
        break;
        
    case 'delete':
        $ok = xoopsPartners_CleanVars( $_REQUEST, 'ok', 0, 'int' );
        $id = xoopsPartners_CleanVars( $_REQUEST, $partners_handler->keyName, 0, 'int' );
        if ( $ok == 1 ) {
            $obj = $partners_handler->get( $id );
            if ( is_object( $obj ) ) {
                if ( $partners_handler->delete( $obj ) ) {
                    // Diplay navigation menu
                    $menu_handler->render( 0 );
                    xoopsPartners_redirect( 'index.php', 1, _XO_AD_DBSUCCESS );
                    // Display Xoops footer
                    xoops_cp_footer();
                }
            }
        } else {
            // Diplay navigation menu
            $menu_handler->render( 0 );
            
            $obj = $partners_handler->get( $id );
            
            $message = ($type == 'partners') ? _XO_AD_DELETE_PARTNER : _XO_AD_DELETE_CAT ;
            $message .= '<div class="txtcenter">' . $obj->getVar( $partners_handler->identifierName, 's' ) . '</div>';
            xoops_confirm( array( 'op' => 'delete', $partners_handler->keyName => $id, 'ok' => 1 ), 'partners.php', $message );
        }
        break;
}
// Display Xoops footer
xoops_cp_footer();
