# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# servidor: localhost
# Tiempo de generacióî: 26-10-2002 a las 21:07:06
# Versióî del servidor: 3.23.32
# Versióî de PHP: 4.2.2
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `xoops_partners`
#

CREATE TABLE partners (
  id           int(10) NOT NULL auto_increment,
  weight       int(10) NOT NULL default '0',
  hits         int(10) NOT NULL default '0',
  url          varchar(150) NOT NULL default '',
  image        varchar(150) NOT NULL default '',
  title        varchar(50) NOT NULL default '',
  description  varchar(255) default NULL,
  status       tinyint(1) NOT NULL default '1',
  approve      tinyint(1) NOT NULL default '1',
  PRIMARY KEY (id),
  KEY status(status)
) ENGINE=MyISAM;

CREATE TABLE `partners_category` (
    `cat_id` INT( 10 ) NOT NULL ,
    `cat_title` VARCHAR( 50 ) NOT NULL ,
    `cat_description` VARCHAR( 255 ) NOT NULL ,
    `cat_weight` INT( 10 ) NOT NULL ,
    `dohtml` TINYINT( 1 ) NOT NULL DEFAULT '1',
    `doxcode` TINYINT( 1 ) NOT NULL DEFAULT '1',
    `dosmiley` TINYINT( 1 ) NOT NULL DEFAULT '1',
    `doimage` TINYINT( 1 ) NOT NULL DEFAULT '1',
    `dobr` TINYINT( 1 ) NOT NULL DEFAULT '0'
) ENGINE=MyISAM;