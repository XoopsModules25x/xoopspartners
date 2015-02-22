<?php
/**
 * Module update page
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
 * @version     $Id: update.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */

if(!defined('XOOPS_ROOT_PATH')) exit ;

/**
 * Function executed during an update of the module
 * 
 * @String  $module  array of the module
 * @return  Boolean
 */
function xoops_module_update_xoopspartners(&$module) 
{
    global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModule;

    if (!partners_fieldExists('category',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `category_id` INT( 10 ) NOT NULL DEFAULT '0' AFTER `status`");
    }
    if (!partners_fieldExists('dohtml',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `dohtml` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `category`");
    }
    if (!partners_fieldExists('doxcode',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `doxcode` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `dohtml`");
    }
    if (!partners_fieldExists('dosmiley',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `dosmiley` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `doxcode`");
    }
    if (!partners_fieldExists('doimage',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `doimage` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `dosmiley`");
    }
    if (!partners_fieldExists('dobr',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `dobr` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `doimage`");
    }
    if (!partners_fieldExists('approve',$xoopsDB->prefix('partners'))) {
        $result = $xoopsDB->queryF("ALTER TABLE `".$xoopsDB->prefix('partners')."` ADD `approve` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `status`");
    }
    
    return true;
}

/**
 * Check if table already exist in mysql
 * 
 * @String  $tablename  name of the table with the Xoops DB prefix
 * @return  Boolean
 */
function content_table_exists( $tablename ) 
{
    global $xoopsDB;
    $result=$xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");
    return($xoopsDB->getRowsNum($result) > 0);
}

/**
 * Check if field already exist in table
 * 
 * @String  $fieldname  name of the field
 * @String  $table      name of the table with the Xoops DB prefix
 * @return  Boolean
 */
function partners_fieldExists( $fieldname, $table )
{
    global $xoopsDB;
    $result=$xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
    return($xoopsDB->getRowsNum($result) > 0);
}

?>