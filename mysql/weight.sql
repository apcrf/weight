/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50713
Source Host           : localhost:3306
Source Database       : weight

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2020-01-14 11:49:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for weight
-- ----------------------------
DROP TABLE IF EXISTS `weight`;
CREATE TABLE `weight` (
  `weight_id` int(11) NOT NULL AUTO_INCREMENT,
  `weight_date` date DEFAULT NULL,
  `weight_value` int(6) DEFAULT NULL,
  PRIMARY KEY (`weight_id`),
  KEY `weight_id` (`weight_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of weight
-- ----------------------------
INSERT INTO `weight` VALUES ('1', '2019-01-03', '70000');
INSERT INTO `weight` VALUES ('2', '2019-01-11', '70050');
INSERT INTO `weight` VALUES ('3', '2019-01-25', '70060');
INSERT INTO `weight` VALUES ('4', '2019-01-01', '70100');
INSERT INTO `weight` VALUES ('5', '2019-02-01', '70100');
INSERT INTO `weight` VALUES ('6', '2019-02-03', '70120');
INSERT INTO `weight` VALUES ('7', '2019-02-11', '70130');
INSERT INTO `weight` VALUES ('8', '2019-02-25', '70100');
INSERT INTO `weight` VALUES ('9', '2019-03-25', '70150');
INSERT INTO `weight` VALUES ('10', '2019-04-25', '70160');
INSERT INTO `weight` VALUES ('11', '2019-05-25', '70190');
INSERT INTO `weight` VALUES ('12', '2019-06-25', '70170');
INSERT INTO `weight` VALUES ('13', '2019-07-25', '70200');
INSERT INTO `weight` VALUES ('14', '2019-08-25', '70210');
INSERT INTO `weight` VALUES ('15', '2019-09-25', '70220');
INSERT INTO `weight` VALUES ('16', '2019-10-25', '70230');
INSERT INTO `weight` VALUES ('17', '2019-10-25', '70240');
INSERT INTO `weight` VALUES ('18', '2019-11-02', '70300');
INSERT INTO `weight` VALUES ('19', '2019-11-25', '70400');
INSERT INTO `weight` VALUES ('20', '2019-12-01', '70300');
INSERT INTO `weight` VALUES ('21', '2019-12-05', '70200');
INSERT INTO `weight` VALUES ('22', '2019-12-11', '70150');
INSERT INTO `weight` VALUES ('23', '2019-12-20', '70100');
INSERT INTO `weight` VALUES ('24', '2019-12-25', '70000');
