<?php
// $Id: partners.php,v 1.9.14.1 2005/08/15 15:04:59 skalpa Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Raul Recio (AKA UNFOR)                                            //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
/**
 * XoopsPartners - a partner affiliation links module
 *
 * @category     Module
 * @package      xoopspartners
 * @subpackage   class
 * @author       Raul Recio (aka UNFOR)
 * @author       XOOPS Module Development Team
 * @copyright    {@link http://xoops.org 2001-2016 XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @link         http://xoops.org XOOPS
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class XoopspartnersPartners
 */
class XoopspartnersPartners extends XoopsObject
{
    protected $db;

    /**
     * constructor
     *
     * @TODO change 'url' to XOBJ_DTYPE_URL
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();

        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('hits', XOBJ_DTYPE_INT, null, true, 10);
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('image', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('status', XOBJ_DTYPE_INT, null, false, 0);
        if (!empty($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            } else {
                $this->load((int)$id);
            }
        }
    }

    /**
     * Returns category title using PHP5
     * @return string
     */
    public function __toString()
    {
        return $this->getVar('title', 's');
    }
}

/**
 * @copyright copyright &copy; 2000 XOOPS.org
 */
class XoopspartnersPartnersHandler extends XoopsPersistableObjectHandler
{
    /**
     * XoopspartnersPartnersHandler constructor.
     * @param XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'partners', 'XoopspartnersPartners', 'id');
    }
}
