<?php
/**
 * Join page for the Xoops Partners Module
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
 * @version     $Id: join.php 9326 2012-04-14 21:53:58Z beckmi $
 * @since       2.3.0
 */
 
// Include header
include_once 'header.php';
if ( $xoopsUser ){
    $op = xoopsPartners_CleanVars( $_REQUEST, 'op', 'add', 'string' );
    // Define template file
    $xoopsOption['template_main'] = 'xoopspartners_join.html';
    // Include Xoops header
    include XOOPS_ROOT_PATH . '/header.php';
    // Add module stylesheet and scripts
    $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/css/class.css', null );
    $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/css/module.css', null );
    $xoTheme->addScript( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/js/functions.js', null, '' );
    // Module Name
    $xoopsTpl->assign('module_name', $xoopsModule->getVar('name', 's'));
    $xoopsTpl->assign('sub_title', _XO_MD_JOIN);
    
    // Load Partners Handler 
    $partners_handler = &xoops_getModuleHandler( 'partners' );
    // Retreive form data for all case
    switch ($op) {
        case 'add': // Add Partner/Category
        // Retreive form data for all case
        $obj = $partners_handler->create();
        $obj->displayJoinForm();
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
                    $xoopsMailer =& getMailer();
                    $xoopsMailer->useMail();
                    $xoopsMailer->setTemplateDir( XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar( 'dirname', 'n') . '/language/'.$xoopsConfig['language'] . '/');
                    $xoopsMailer->setTemplate( 'join.tpl' );
                    $xoopsMailer->assign( 'SITENAME', $xoopsConfig['sitename'] );
                    $xoopsMailer->assign( 'SITEURL', XOOPS_URL . '/');
                    $xoopsMailer->assign( 'IP', $_SERVER['REMOTE_ADDR']);
                    $xoopsMailer->assign( 'USER', $xoopsUser->getVar( 'uname', 's' ) );
                    $xoopsMailer->assign( 'TITLE', $obj->getVar( 'title', 's' ) );
                    // Get category title
                    $category_handler = &xoops_getModuleHandler( 'category' );
                    $category_handler->get( $obj->getVar( 'category_id', 's' ) );
                    $xoopsMailer->assign( 'CATEGORY', $obj->getVar( 'cat_title', 's' ) );
                    
                    $xoopsMailer->setToEmails( $xoopsConfig['adminmail'] );
                    $xoopsMailer->setFromEmail( $xoopsUser->getVar( 'email', 's' ) );
                    $xoopsMailer->setFromName( $xoopsUser->getVar( 'uname', 's' ) );
                    $xoopsMailer->setSubject(sprintf( _XO_MD_NEWPARTNER, $xoopsConfig['sitename'] ) );
                    if ( !$xoopsMailer->send() ) {
                    }
                    // Redirect
                    xoopsPartners_redirect( 'index.php', 1, _XO_AD_DBSUCCESS );
                    // Display Xoops footer
                    xoops_cp_footer();
                    exit;
                }
            }
            // Display Error
            xoops_error( $ret, _XO_AD_PARTNER_SUBERROR );
            break;    
    }
} else {
    redirect_header( 'index.php', 2, _NOPERM );
}
// Include Xoops Footer
include_once XOOPS_ROOT_PATH . '/footer.php';

?>