/*
Navicat MariaDB Data Transfer

Source Server         : 
Source Server Version : 
Source Host           : 
Source Database       : BnMake

Target Server Type    : MariaDB
Target Server Version : 100021
File Encoding         : 65001

Date: 2015-11-25 23:45:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for Requests
-- ----------------------------
DROP TABLE IF EXISTS `Requests`;
CREATE TABLE `Requests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Button` varchar(255) NOT NULL,
  `Processed` tinyint(4) NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of Requests
-- ----------------------------
INSERT INTO `Requests` VALUES ('52', 'upstairs', '1', '2015-11-06 03:26:42');
INSERT INTO `Requests` VALUES ('53', 'downstairs', '1', '2015-11-06 03:30:43');
INSERT INTO `Requests` VALUES ('54', 'outside', '1', '2015-11-06 03:33:03');
INSERT INTO `Requests` VALUES ('55', 'upstairs', '1', '2015-11-06 03:36:41');
INSERT INTO `Requests` VALUES ('56', 'downstairs', '1', '2015-11-06 03:36:47');
INSERT INTO `Requests` VALUES ('57', 'outside', '1', '2015-11-06 03:36:57');
INSERT INTO `Requests` VALUES ('58', 'outside', '1', '2015-11-06 03:37:02');
INSERT INTO `Requests` VALUES ('59', 'downstairs', '1', '2015-11-06 03:37:07');

-- ----------------------------
-- Table structure for Status
-- ----------------------------
DROP TABLE IF EXISTS `Status`;
CREATE TABLE `Status` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Upstairs` tinyint(1) NOT NULL DEFAULT '0',
  `Downstairs` tinyint(1) NOT NULL DEFAULT '0',
  `Outside` tinyint(1) NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of Status
-- ----------------------------
INSERT INTO `Status` VALUES ('1', '0', '1', '1', '2015-11-08 12:44:57');
