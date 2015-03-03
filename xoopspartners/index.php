<?php
/**
 * Main page for the Xoops Partners Module
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
 * @version     $Id: index.php 9326 2012-04-14 21:53:58Z beckmi $
 * @since       2.3.0
 */
 
// Include header
include_once 'header.php';
// Get class handler
$category_handler = &xoops_getModuleHandler( 'category' );
$partners_handler = &xoops_getModuleHandler( 'partners' );

$cat_id = xoopsPartners_CleanVars( $_REQUEST, 'cat_id', 0, 'int' );
if ( $cat_id < 1 ) {
    // Define template file
    $xoopsOption['template_main'] = 'xoopspartners_index.html';
    // Include Xoops header
    include XOOPS_ROOT_PATH . '/header.php';
    // Add module stylesheet and scripts
    $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/css/class.css', null );
    $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/css/module.css', null );
    $xoTheme->addScript( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/js/functions.js', null, '' );
    
    $xoopsTpl->assign('module_name', $xoopsModule->getVar('name', 's'));
    
    $objects = $category_handler->getObj();
    if ( $objects['count'] > 0 ) {
        foreach( $objects['list'] as $object ) {
            $category = array();
            $category['id']   = $object->getVar( 'cat_id' );
            $category['name'] = $object->getVar( 'cat_title' );
            $category['desc'] = $object->getVar( 'cat_description' );

            $contentsObj = $partners_handler->getActive( $object->getVar( 'cat_id' ) );
            if ( $contentsObj['count'] ) {
                foreach( $contentsObj['list'] as $content ) {
                    $category['partners'][] = $content->toArray();
                }
            }
            $xoopsTpl->append_by_ref( 'categories', $category );
            unset( $category );
        }
    }

} else {
    // Define template file
    $xoopsOption['template_main'] = 'xoopspartners_category.html';
    // Include Xoops header
    include XOOPS_ROOT_PATH . '/header.php';
    // Add module stylesheet and scripts
    $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/css/class.css', null );
    $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/css/module.css', null );
    $xoTheme->addScript( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/js/functions.js', null, '' );
    // Template variables
    $xoopsTpl->assign('module_name', $xoopsModule->getVar('name', 's'));
    $cat = $category_handler->get( $cat_id );
    $xoopsTpl->assign('category', $cat->toArray());
    $partners = $partners_handler->getActive( $cat_id );
    if ( $partners['count'] > 0 ) {
        foreach( $partners['list'] as $partner ) {
            $xoopsTpl->append_by_ref( 'list', $partner->toArray() );
        }
    }
}
// Include Xoops footer
include_once XOOPS_ROOT_PATH . '/footer.php';
