<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *--------------------------------------
 * Author: Raul Recio (AKA UNFOR)
 * Project: The XOOPS Project
 *--------------------------------------
 */

/**
 * XoopsPartners - a partner affiliation links module
 *
 * @package      module\Xoopspartners\language
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link https://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         https://xoops.org XOOPS
 */
$moduleDirName = basename(dirname(dirname(__DIR__)));

define('_AM_XOOPSPARTNERS_URL', 'URL');
define('_AM_XOOPSPARTNERS_HITS', 'Hits');
define('_AM_XOOPSPARTNERS_IMAGE', 'Image');
define('_AM_XOOPSPARTNERS_TITLE', 'Title');
define('_AM_XOOPSPARTNERS_WEIGHT', 'Weight');
define('_AM_XOOPSPARTNERS_DESCRIPTION', 'Description');
define('_AM_XOOPSPARTNERS_STATUS', 'Status');
define('_AM_XOOPSPARTNERS_ACTIVE', 'Active');
define('_AM_XOOPSPARTNERS_INACTIVE', 'Inactive');
define('_AM_XOOPSPARTNERS_REORDER', 'Sort');
define('_AM_XOOPSPARTNERS_UPDATED', 'Settings Updated!');
define('_AM_XOOPSPARTNERS_NOTUPDATED', 'Could not update settings!');
define('_AM_XOOPSPARTNERS_BESURE', 'Be sure to enter at least a title, a URL and a description.');
define('_AM_XOOPSPARTNERS_NOEXIST', 'File is not a valid image file or it doesn\'t exist');
define('_AM_XOOPSPARTNERS_ADDPARTNER', 'Add');
define('_AM_XOOPSPARTNERS_EDITPARTNER', 'Edit');
define('_AM_XOOPSPARTNERS_SUREDELETE', 'Are you sure you want to delete this site?');
define('_AM_XOOPSPARTNERS_IMAGE_ERROR', 'Image size is larger than 150x80!');
define('_AM_XOOPSPARTNERS_ADD', 'Add Partner');
define('_AM_XOOPSPARTNERS_AUTOMATIC_SORT', 'Automatic sort');
define('_AM_XOOPSPARTNERS_UPDATE', 'Update');

//1.11

// About.php
define('_AM_XOOPSPARTNERS_ABOUT_RELEASEDATE', 'Released: ');
define('_AM_XOOPSPARTNERS_ABOUT_UPDATEDATE', 'Updated: ');
define('_AM_XOOPSPARTNERS_ABOUT_AUTHOR', 'Author: ');
define('_AM_XOOPSPARTNERS_ABOUT_CREDITS', 'Credits: ');
define('_AM_XOOPSPARTNERS_ABOUT_LICENSE', 'License: ');
define('_AM_XOOPSPARTNERS_ABOUT_MODULE_STATUS', 'Status: ');
define('_AM_XOOPSPARTNERS_ABOUT_WEBSITE', 'Website: ');
define('_AM_XOOPSPARTNERS_ABOUT_AUTHOR_NAME', 'Author name: ');
define('_AM_XOOPSPARTNERS_ABOUT_CHANGELOG', 'Change Log');
define('_AM_XOOPSPARTNERS_ABOUT_MODULE_INFO', 'Module Infos');
define('_AM_XOOPSPARTNERS_ABOUT_AUTHOR_INFO', 'Author Infos');
define('_AM_XOOPSPARTNERS_ABOUT_DESCRIPTION', 'Description: ');
define('_AM_XOOPSPARTNERS_EMPTYDATABASE', 'There is nothing to sort. Please add some Partners first!');

// Configuration
define('_AM_XOOPSPARTNERS_CONFIG_CHECK', 'Configuration Check');
define('_AM_XOOPSPARTNERS_CONFIG_PHP', 'Minimum PHP required: %s (your version is %s)');
define('_AM_XOOPSPARTNERS_CONFIG_XOOPS', 'Minimum XOOPS required:  %s (your version is %s)');

define('_AM_XOOPSPARTNERS_ACTIONS', 'Actions');
define('_AM_XOOPSPARTNERS_INVALIDID', 'No partner exists with this ID');

// text in admin footer
define('_AM_XOOPSPARTNERS_ADMIN_FOOTER', "<div class='center smallsmall italic pad5'><strong>{$moduleDirName}</strong> is maintained by the <a class='tooltip' rel='external' href='https://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");

//1.12
define('_AM_XOOPSPARTNERS_NOPARTNERS', 'No Partners in the database.');

//1.13
define('_AM_XOOPSPARTNERS_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('_AM_XOOPSPARTNERS_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');

define('_AM_XOOPSPARTNERS_ADMIN_FOOTER_STR1', 'is maintainted by the');
define('_AM_XOOPSPARTNERS_ADMIN_FOOTER_STR2', 'Visit');

// Help Issues page defines
define('_AM_XOOPSPARTNERS_ISSUES_ERR_UNKNOWN', 'Unknown Error');
define('_AM_XOOPSPARTNERS_ISSUES_ERR_STATUS', 'Unknown Status');
define('_AM_XOOPSPARTNERS_ISSUES_NONE', 'There are currently no open issues.');
define('_AM_XOOPSPARTNERS_ISSUES_NOTE', 'Note: * indicates issue is a GitHub pull request');
define('_AM_XOOPSPARTNERS_ISSUES_OPEN', 'Open Issues');
define('_AM_XOOPSPARTNERS_HELP_ISSUE', 'Issue #');
define('_AM_XOOPSPARTNERS_HELP_DATE', 'Date');
define('_AM_XOOPSPARTNERS_HELP_TITLE', 'Title');
define('_AM_XOOPSPARTNERS_HELP_SUBMITTER', 'Submitter');
