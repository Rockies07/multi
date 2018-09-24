/*
SQLyog Community Edition- MySQL GUI v8.03 
MySQL - 5.1.36-community-log : Database - billbase
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`billbase` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `billbase`;

/*Table structure for table `member_submission` */

DROP TABLE IF EXISTS `member_submission`;

CREATE TABLE `member_submission` (
  `memberid` varchar(8) NOT NULL DEFAULT '',
  `set_type` varchar(10) NOT NULL DEFAULT '',
  `amount` float(15,2) NOT NULL,
  `remarks` varchar(100) DEFAULT '',
  `refno` int(5) NOT NULL,
  `pageref` varchar(5) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `proj_entries` */

DROP TABLE IF EXISTS `proj_entries`;

CREATE TABLE `proj_entries` (
  `date` date NOT NULL DEFAULT '0000-00-00',
  `project` varchar(10) NOT NULL DEFAULT '',
  `stats` varchar(3) NOT NULL DEFAULT '',
  `account` varchar(8) NOT NULL DEFAULT '',
  `remarks` varchar(100) DEFAULT '',
  `amt` float(15,2) NOT NULL,
  `submittedby` varchar(8) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `no` int(5) NOT NULL AUTO_INCREMENT,
  `projcode` varchar(10) NOT NULL,
  `status` datetime NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `submission_details` */

DROP TABLE IF EXISTS `submission_details`;

CREATE TABLE `submission_details` (
  `refno` int(5) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `sub_type` varchar(10) NOT NULL DEFAULT '',
  `set_remarks` varchar(100) NOT NULL DEFAULT '',
  `total_amt` float(15,2) NOT NULL,
  `timestamp` datetime NOT NULL,
  `pageref` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`refno`,`timestamp`)
) ENGINE=MyISAM AUTO_INCREMENT=1016 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
