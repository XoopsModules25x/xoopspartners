<?php
/**
 * Module specific Functions for Xoops Parteners
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
 * @version     $Id: functions.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */

/**
 * xoopsFaq_CleanVars()
 *
 * @return
 */
function xoopsPartners_CleanVars( &$global, $key, $default = '', $type = 'int' ) {
    switch ( $type ) {
        case 'string':
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_MAGIC_QUOTES ) : $default;
            break;
        case 'int':
        default:
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_NUMBER_INT ) : $default;
            break;
    }
    if ( $ret === false ) {
        return $default;
    }

    return $ret;
}

/**
 * xoopsParteners_setting
 *
 * @author      Instant Zero (http://xoops.instant-zero.com)
 * @copyright   Instant Zero
 * @param       string      $option module option's name
 **/
function xoopsPartners_setting($option, $repmodule='xoopspartners')
{
    global $xoopsModuleConfig, $xoopsModule;
    static $tbloptions= Array();
    if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
        return $tbloptions[$option];
    }

    $retval = false;
    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if(isset($xoopsModuleConfig[$option])) {
            $retval= $xoopsModuleConfig[$option];
        }
    } else {
        $module_handler =& xoops_gethandler('module');
        $module =& $module_handler->getByDirname($repmodule);
        $config_handler =& xoops_gethandler('config');
        if ($module) {
            $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
            if(isset($moduleConfig[$option])) {
                $retval= $moduleConfig[$option];
            }
        }
    }
    $tbloptions[$option]=$retval;

    return $retval;
}

/**
 * Return if Xoops Partners use an HTML editor
 *
 * @return  boolean
 */
function xoopsPartners_isEditorHTML() {
    global $xoopsModuleConfig;
    if ( isset( $xoopsModuleConfig['editor'] ) && in_array( $xoopsModuleConfig['editor'], array( 'tinymce', 'fckeditor', 'koivi', 'inbetween', 'spaw' ) ) ) {
        return true;
    }

    return false;
}

/**
 * Redirect to any page inside administration area
 *
 */
function xoopsPartners_redirect($url, $time = 3, $message = '') {
    global $xoopsModule;
    if ( preg_match( "/[\\0-\\31]|about:|script:/i", $url) ) {
        if (!preg_match('/^\b(java)?script:([\s]*)history\.go\(-[0-9]*\)([\s]*[;]*[\s]*)$/si', $url) ) {
            $url = XOOPS_URL;
        }
    }
    // Create Template instance
    $tpl = new XoopsTpl();
    // Assign Vars
    $tpl->assign('url', $url);
    $tpl->assign('time', $time);
    $tpl->assign('message', $message);
    $tpl->assign('ifnotreload', sprintf(_IFNOTRELOAD, $url));
    // Call template file
    echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/admin/xoopspartners_redirect.html');
    // Force redirection
    header("refresh: ".$time."; url=".$url);
}
