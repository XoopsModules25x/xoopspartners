# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# --------------------------------------------------------

#
# Table structure for `partners` table
#

CREATE TABLE partners (
  id          INT(10)      NOT NULL AUTO_INCREMENT,
  weight      INT(10)      NOT NULL DEFAULT '0',
  hits        INT(10)      NOT NULL DEFAULT '0',
  url         VARCHAR(150) NOT NULL DEFAULT '',
  image       VARCHAR(150) NOT NULL DEFAULT '',
  title       VARCHAR(50)  NOT NULL DEFAULT '',
  description VARCHAR(255)          DEFAULT NULL,
  status      TINYINT(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (id),
  KEY status(status)
)
  ENGINE = MyISAM;
