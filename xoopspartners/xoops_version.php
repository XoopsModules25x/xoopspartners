<?php
/**
 * Module main page
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
 * @version     $Id: xoops_version.php 9326 2012-04-14 21:53:58Z beckmi $
 * @since       2.3.0
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

/**
 * Module configs
 */
$modversion = array(
    'name'         => _XO_MI_PARTNERS_NAME,
    'description'  => _XO_MI_PARTNERS_DESC,
    'official'     => 1,
    'version'      => 1.1,
    'status'       => 'Beta',
    'releasedate'  => 'Friday 10.4.2009',
    'author'       => 'Andricq Nicolas (AKA MusS)',
    'credits'      => 'The Xoops Module Development Team',
    'contributors' => '',
    'image'        => 'images/logo.png',
	'website_url'  => 'http://www.xoops.org',
	'dirname'      => basename( dirname( __FILE__ ) )
);

/**
 * Module Sql
 */
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

/**
 * Module SQL Tables
 */
$modversion['tables'] = array( 'partners' );

/**
 * Module Update
 */
$modversion['onUpdate'] = 'include/update.php';

/**
 * Module Admin
 */
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

/**
 * Module Main
 */
$modversion['hasMain'] = 1;
global $xoopsUser;
if ($xoopsUser) {
    $modversion['sub'][1]['name'] = _XO_MI_MENU_JOIN;
    $modversion['sub'][1]['url']  = 'join.php';
}
/**
 * Module Search
 */
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = 'include/search.inc.php';
//$modversion['search']['func'] = 'xoopspartners_search';

/**
 * Module Templates
 */
$modversion['templates'][] = array( 'file' => 'xoopspartners_header.html', 'description' => 'Header template' );
$modversion['templates'][] = array( 'file' => 'xoopspartners_index.html', 'description' => 'Partners main Screen' );
$modversion['templates'][] = array( 'file' => 'xoopspartners_category.html', 'description' => 'Dsiplay partner category' );
$modversion['templates'][] = array( 'file' => 'xoopspartners_join.html', 'description' => 'Shows Join to the partners Form' );

/**
 * Module Comments
 */
//$modversion['hasComments'] = 1;
//$modversion['comments'][] = array( 'pageName' => 'index.php', 'itemName' => 'cat_id' );
 
/**
 * Module blocks
 */
$modversion['blocks'][] = array(
    'file'        => 'partners.php',
    'name'        => _XO_MI_PARTNERS_NAME,
    'description' => _XO_MI_PARTNERS_DESC,
    'show_func'   => 'b_xoopsPartners_show',
    'edit_func'   => 'b_xoopsPartners_edit',
    'options'	  => '0',
    'template'    => 'xoopspartners_block_site.html'
    );

/**
 * Module configs
 */
xoops_load('xoopslists');

$modversion['config'][] = array(
    'name'        => 'editor',
    'title'	      => '_XO_MI_PARTNERS_EDITOR',
    'description' => '_XO_MI_PARTNERS_EDITOR_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor')
    );
$modversion['config'][] = array(
    'name'        => 'cookietime',
    'title'	      => '_XO_MI_PARTNERS_RECLICK',
    'description' => '_XO_MI_PARTNERS_RECLICK_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 86400,
    'options'     => array('_XO_MI_PARTNERS_HOUR' => '3600','_XO_MI_PARTNERS_3HOURS' => '10800','_XO_MI_PARTNERS_5HOURS' =>  '18000','_XO_MI_PARTNERS_10HOURS'  =>  '36000','_XO_MI_PARTNERS_DAY' => '86400')
    );

?>