<?php
//
// Support Francophone de Xoops (www.frxoops.org)
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
$adminMyDirName = basename(dirname(dirname(__DIR__)));

define('_AM_XPARTNERS_URL', 'URL');
define('_AM_XPARTNERS_HITS', 'Hits');
define('_AM_XPARTNERS_IMAGE', 'Image');
define('_AM_XPARTNERS_TITLE', 'Titre');
define('_AM_XPARTNERS_WEIGHT', 'Poids');
define('_AM_XPARTNERS_DESCRIPTION', 'Description');
define('_AM_XPARTNERS_STATUS', 'Statut');
define('_AM_XPARTNERS_ACTIVE', 'Actif');
define('_AM_XPARTNERS_INACTIVE', 'Inactif');
define('_AM_XPARTNERS_REORDER', 'Trié par');
define('_AM_XPARTNERS_UPDATED', 'Paramètres mis à jour !');
define('_AM_XPARTNERS_NOTUPDATED', 'Impossible de mettre à jour les paramètres !');
define('_AM_XPARTNERS_BESURE', "Assurez-vous d'entrer au moins un titre, une URL et une description.");
define('_AM_XPARTNERS_NOEXIST', "Le fichier image n'existe pas");
define('_AM_XPARTNERS_ADDPARTNER', 'Ajouter');
define('_AM_XPARTNERS_EDITPARTNER', 'Editer');
define('_AM_XPARTNERS_SUREDELETE', 'Etes-vous sûr de vouloir effacer ce site ?');
define('_AM_XPARTNERS_IMAGE_ERROR', "La taille de l'image est supérieur à 150x80 !");
define('_AM_XPARTNERS_ADD', 'Ajouter le partenaire');
define('_AM_XPARTNERS_AUTOMATIC_SORT', 'Tri automatique');
define('_AM_XPARTNERS_UPDATE', 'Mise � jour');

/**
 * @translation     Communauté XOOPS Francophone
 * @specification   _LANGCODE: fr
 * @specification   _CHARSET: UTF-8 sans bom
 *
 **/
//1.11

// About.php
define('_AM_XPARTNERS_ABOUT_RELEASEDATE', 'Released: ');
define('_AM_XPARTNERS_ABOUT_UPDATEDATE', 'Updated: ');
define('_AM_XPARTNERS_ABOUT_AUTHOR', 'Author: ');
define('_AM_XPARTNERS_ABOUT_CREDITS', 'Credits: ');
define('_AM_XPARTNERS_ABOUT_LICENSE', 'License: ');
define('_AM_XPARTNERS_ABOUT_MODULE_STATUS', 'Status: ');
define('_AM_XPARTNERS_ABOUT_WEBSITE', 'Website: ');
define('_AM_XPARTNERS_ABOUT_AUTHOR_NAME', 'Author name: ');
define('_AM_XPARTNERS_ABOUT_CHANGELOG', 'Change Log');
define('_AM_XPARTNERS_ABOUT_MODULE_INFO', 'Module Infos');
define('_AM_XPARTNERS_ABOUT_AUTHOR_INFO', 'Author Infos');
define('_AM_XPARTNERS_ABOUT_DESCRIPTION', 'Description: ');
define('_AM_XPARTNERS_EMPTYDATABASE', 'There is nothing to sort. Please add some Partners first!');

// Configuration
define('_AM_XPARTNERS_CONFIG_CHECK', 'Configuration Check');
define('_AM_XPARTNERS_CONFIG_PHP', 'Minimum PHP required: %s (your version is %s)');
define('_AM_XPARTNERS_CONFIG_XOOPS', 'Minimum XOOPS required:  %s (your version is %s)');

define('_AM_XPARTNERS_ACTIONS', 'Actions');
define('_AM_XPARTNERS_INVALIDID', 'No partner exists with this ID');

// text in admin footer
define('_AM_XPARTNERS_ADMIN_FOOTER', "<div class='center smallsmall italic pad5'><strong>{$adminMyDirName}</strong> is maintained by the <a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");
