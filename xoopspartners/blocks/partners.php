<?php
/**
 * Partner Block
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
 * @version     $Id: partners.php 10055 2012-08-11 12:46:10Z beckmi $
 * @since       2.3.0
 */

define('_XOOPSPARTNERS_DIRNAME', basename( dirname( dirname( __FILE__ ) ) ) );

function b_xoopsPartners_show( $options ) {
	global $xoTheme;
	$block = array();
    // Get module handler
	$partners_handler = &xoops_getModuleHandler( 'partners', _XOOPSPARTNERS_DIRNAME );
	// Add stylesheet and scripts	
	$xoTheme->addStylesheet( XOOPS_URL . '/modules/' . _XOOPSPARTNERS_DIRNAME . '/css/class.css', null );
	$xoTheme->addScript( XOOPS_URL . '/modules/' . _XOOPSPARTNERS_DIRNAME . '/js/functions.js', null, '' );
    $xoTheme->addScript( XOOPS_URL . '/modules/' . _XOOPSPARTNERS_DIRNAME . '/js/mootools-1.2-core.js', null);
    $xoTheme->addScript( XOOPS_URL . '/modules/' . _XOOPSPARTNERS_DIRNAME . '/js/mooticker.js', null);
    // Get partner list
    $partners = $partners_handler->getActive( $options[1] );
	if ( $partners['count'] > 0 ) {
		foreach( $partners['list'] as $partner ) {
            $block[] = $partner->toArray();
		}
	}
	// Return infos
	return $block;
}

function b_xoopsPartners_edit( $options ) {
    // Get module handler
    $category_handler = &xoops_getModuleHandler( 'category', _XOOPSPARTNERS_DIRNAME );
    // Construct option
    $form = _XO_MB_PARTNERS_CATEGORY . '<select name="' . $options[1] . '">';
    $objects = $category_handler->getObj();
	if ( $objects['count'] > 0 ) {
		foreach( $objects['list'] as $object ) {
			$category = array();
			$category['id']   = $object->getVar( 'cat_id' );
			$category['name'] = $object->getVar( 'cat_title' );
			$category['desc'] = $object->getVar( 'cat_description' );
			$form .= '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';  
			unset( $category );
		}
	}
    $form .= '</select>';
    // Return form
	return $form;
}
?>