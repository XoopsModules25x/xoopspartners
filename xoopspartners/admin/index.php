<?php
/**
 * Admin Index File for Xoops Partners
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
 * @version     $Id: index.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */

// Include header
include 'header.php';
// Display Xoops header
xoops_cp_header();
// Diplay navigation menu
$menu_handler->render( 0 );
// Create Template instance
$tpl = new XoopsTpl();
// Get module handler
$partners_handler = &xoops_getModuleHandler( 'partners' );
$category_handler = &xoops_getModuleHandler( 'category' );
$objects = $category_handler->getObj();
if ( $objects['count'] > 0 ) {
    foreach( $objects['list'] as $object ) {
        $category = array();
        $category['id'] = $object->getVar( 'cat_id' );
        $category['name'] = $object->getVar( 'cat_title' );
        $category['desc'] = $object->getVar( 'cat_description' );
    
        $contentsObj = $partners_handler->getByCategory( $object->getVar( 'cat_id' ) );
        if ( $contentsObj['count'] ) {
            foreach( $contentsObj['list'] as $content ) {
                $category['partners'][] = $content->toArray();	
            }
        }
        $tpl->append_by_ref( 'categories', $category );
        unset( $category );
    }
}
// Call template file
echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/admin/xoopspartners_index.html');
// Display Xoops footer
xoops_cp_footer();
    
?>
