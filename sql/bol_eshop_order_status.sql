/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 100138
Source Host           : localhost:3306
Source Database       : importpark

Target Server Type    : MYSQL
Target Server Version : 100138
File Encoding         : 65001

Date: 2022-05-01 13:54:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bol_eshop_order_status
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_order_status`;
CREATE TABLE `bol_eshop_order_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of bol_eshop_order_status
-- ----------------------------
INSERT INTO `bol_eshop_order_status` VALUES ('1', 'Pending', 'pending', '#7f8c8d', null, '2022-02-21 16:30:25', '2022-02-21 16:30:25');
INSERT INTO `bol_eshop_order_status` VALUES ('2', 'Delivered', 'delivered', '#27ae60', null, '2022-02-21 16:30:47', '2022-02-21 16:30:47');
INSERT INTO `bol_eshop_order_status` VALUES ('3', 'Cancel', 'cancel', '#e74c3c', null, '2022-02-21 16:30:59', '2022-02-21 16:30:59');

-- ----------------------------
-- Table structure for bol_eshop_payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_payment_methods`;
CREATE TABLE `bol_eshop_payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of bol_eshop_payment_methods
-- ----------------------------
INSERT INTO `bol_eshop_payment_methods` VALUES ('1', 'Cash on delivery', 'cash-delivery', '', '1', null, '2022-02-21 16:31:19', '2022-02-21 16:31:26');

-- ----------------------------
-- Table structure for bol_eshop_shipping_methods
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_shipping_methods`;
CREATE TABLE `bol_eshop_shipping_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of bol_eshop_shipping_methods
-- ----------------------------
INSERT INTO `bol_eshop_shipping_methods` VALUES ('1', 'eCourier', 'ecourier', '60', '', '1', null, '2022-02-21 16:31:48', '2022-02-21 19:49:22');
