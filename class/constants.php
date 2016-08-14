<?php
/*
               XOOPS - PHP Content Management System
                   Copyright (c) 2000 XOOPS.org
                      <http://www.xoops.org/>
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting
 source code which is considered copyrighted (c) material of the
 original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
*/
/**
 * Module: XoopsPartners - a partner affiliation links module
 *
 * Class to define XOOPS Partners constant values. These constants are
 * used to make the code easier to read and to keep values in central
 * location if they need to be changed.  These should not normally need
 * to be modified. If they are to be modified it is recommended to change
 * the value(s) before module installation. Additionally the module may not
 * work correctly if trying to upgrade if these values have been changed.
 *
 * @package      module\xoopspartners\class
 * @author       zyspec <owners@zyspec.com>
 * @author       XOOPS Module Development Team
 * @copyright    http://xoops.org 2001-2016 &copy; XOOPS Project
 * @license      http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @since        1.12
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Interface XoopspartnersConstants
 */
interface XoopspartnersConstants
{
    /**#@+
     * Constant definition
     */
    /**
     * no delay XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_NONE = 0;
    /**
     * short XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_SHORT = 1;
    /**
     * medium XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_MEDIUM = 3;
    /**
     * long XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_LONG = 7;
    /**
     * default image width  (don't change here, change in Preferences)
     */
    const DEFAULT_MAX_WIDTH = 150;
    /**
     * default image height (don't change here, change in Preferences)
     */
    const DEFAULT_MAX_HEIGHT = 110;
    /**
     * value indicates poll options are shown as list
     */
    const DEFAULT_UPLOAD_SIZE = 1048576;
    /**
     * default partner ID
     */
    const DEFAULT_PID = 0;
    /**
     * default module ID
     */
    const DEFAULT_MID = 0;
    /**
     *  indicates a partner title should be displayed
     */
    const SHOW_TITLE = 2;
    /**
     *  indicates a partner image should be displayed
     */
    const SHOW_IMAGE = 1;
    /**
     *  indicates a partner listing is inactive
     */
    const STATUS_INACTIVE = 0;
    /**
     *  indicates a partner listing is active
     */
    const STATUS_ACTIVE = 1;
    /**
     * default poll weight for display order
     */
    const DEFAULT_WEIGHT = 0;
    /**
     * cannot join
     */
    const JOIN_NOT_OK = 0;
    /**
     * ok to join
     */
    const JOIN_OK = 1;
    /**
     * confirm not ok to take action
     */
    const CONFIRM_NOT_OK = 0;
    /**
     * confirm ok to take action
     */
    const CONFIRM_OK = 1;
    /**#@-*/
}
