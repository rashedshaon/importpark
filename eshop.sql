/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100419
 Source Host           : localhost:3306
 Source Schema         : importpark

 Target Server Type    : MySQL
 Target Server Version : 100419
 File Encoding         : 65001

 Date: 26/01/2022 08:44:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bol_eshop_brands
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_brands`;
CREATE TABLE `bol_eshop_brands`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `bol_eshop_brands_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_brands
-- ----------------------------
INSERT INTO `bol_eshop_brands` VALUES (1, 'BOL', 'bol', '', 3, 0, '2021-06-24 16:35:37', '2021-07-05 15:24:35');
INSERT INTO `bol_eshop_brands` VALUES (2, 'Yello', 'yello', '', 2, 0, '2021-06-24 16:35:46', '2021-07-05 15:24:35');
INSERT INTO `bol_eshop_brands` VALUES (3, 'BEXIMCO', 'beximco', '', 4, 0, '2021-06-24 16:35:58', '2021-07-05 15:24:35');
INSERT INTO `bol_eshop_brands` VALUES (4, 'Non Brand', 'non-brand', '', 1, 1, '2021-07-05 15:18:38', '2021-07-05 15:24:35');

-- ----------------------------
-- Table structure for bol_eshop_cart_items
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_cart_items`;
CREATE TABLE `bol_eshop_cart_items`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_cart_items
-- ----------------------------
INSERT INTO `bol_eshop_cart_items` VALUES (18, 2, 5, '', '', 3, '2022-01-20 10:33:06', '2022-01-20 14:13:04');
INSERT INTO `bol_eshop_cart_items` VALUES (19, 2, 19, '', '', 3, '2022-01-20 10:33:10', '2022-01-20 14:13:36');
INSERT INTO `bol_eshop_cart_items` VALUES (20, 1, 12, '', '', 1, '2022-01-24 20:21:17', '2022-01-24 20:21:17');
INSERT INTO `bol_eshop_cart_items` VALUES (21, 1, 9, '', '', 1, '2022-01-24 20:21:22', '2022-01-24 20:21:22');

-- ----------------------------
-- Table structure for bol_eshop_carts
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_carts`;
CREATE TABLE `bol_eshop_carts`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `shipping_method_id` int(11) NULL DEFAULT NULL,
  `coupon_id` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_carts
-- ----------------------------
INSERT INTO `bol_eshop_carts` VALUES (1, '16256385238', NULL, 1, NULL, '2021-07-07 12:24:36', '2022-01-25 15:02:55');
INSERT INTO `bol_eshop_carts` VALUES (2, '16257461106', NULL, NULL, NULL, '2021-07-08 18:14:33', '2021-07-08 18:14:33');
INSERT INTO `bol_eshop_carts` VALUES (3, '16316202146', NULL, NULL, NULL, '2021-09-14 17:50:46', '2021-09-14 17:50:46');
INSERT INTO `bol_eshop_carts` VALUES (4, '16347077797', 2, 2, NULL, '2021-12-13 15:09:00', '2021-12-28 14:48:16');

-- ----------------------------
-- Table structure for bol_eshop_categories
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_categories`;
CREATE TABLE `bol_eshop_categories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `nest_depth` int(11) NULL DEFAULT NULL,
  `nest_right` int(11) NULL DEFAULT NULL,
  `nest_left` int(11) NULL DEFAULT NULL,
  `parent_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bol_eshop_categories_parent_id_index`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_categories
-- ----------------------------
INSERT INTO `bol_eshop_categories` VALUES (1, 'category 1', 'category-1', '', 0, NULL, 4, 1, NULL, '', '', '2021-06-24 15:08:01', '2021-06-24 15:08:38');
INSERT INTO `bol_eshop_categories` VALUES (2, 'category 2', 'category-2', '', 0, 1, 3, 2, 1, '', '', '2021-06-24 15:08:19', '2021-06-24 15:08:38');
INSERT INTO `bol_eshop_categories` VALUES (3, 'category 3', 'category-3', '', 0, NULL, 6, 5, NULL, '', '', '2021-06-24 15:08:31', '2021-06-24 15:08:31');

-- ----------------------------
-- Table structure for bol_eshop_currencies
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_currencies`;
CREATE TABLE `bol_eshop_currencies`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_currencies
-- ----------------------------
INSERT INTO `bol_eshop_currencies` VALUES (1, 'BDT', 'bdt', '$', 1, 1, NULL, '2021-06-30 18:17:05', '2021-06-30 18:17:05');

-- ----------------------------
-- Table structure for bol_eshop_order_items
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_order_items`;
CREATE TABLE `bol_eshop_order_items`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10, 0) NOT NULL,
  `actual_price` decimal(10, 0) NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bol_eshop_order_status
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_order_status`;
CREATE TABLE `bol_eshop_order_status`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_order_status
-- ----------------------------
INSERT INTO `bol_eshop_order_status` VALUES (1, 'New', 'new', '#1abc9c', NULL, '2021-06-30 18:22:42', '2021-07-01 14:35:45');
INSERT INTO `bol_eshop_order_status` VALUES (2, 'In progress', 'progress', '#3498db', NULL, '2021-06-30 18:24:17', '2021-07-01 14:36:14');
INSERT INTO `bol_eshop_order_status` VALUES (3, 'Complete', 'complete', '#27ae60', NULL, '2021-06-30 18:24:30', '2021-07-01 14:36:26');
INSERT INTO `bol_eshop_order_status` VALUES (4, 'Cancel', 'cancel', '#e74c3c', NULL, '2021-06-30 18:24:55', '2021-07-01 14:36:33');

-- ----------------------------
-- Table structure for bol_eshop_orders
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_orders`;
CREATE TABLE `bol_eshop_orders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `billing_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payment_mothod` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_mothod` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_percent` decimal(10, 0) NULL DEFAULT NULL,
  `other_deduction` decimal(10, 0) NULL DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `coupon_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `coupon_discount` decimal(10, 0) NULL DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bol_eshop_payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_payment_methods`;
CREATE TABLE `bol_eshop_payment_methods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_payment_methods
-- ----------------------------
INSERT INTO `bol_eshop_payment_methods` VALUES (1, 'Salary Deduction', 'salary_deduction', 1, NULL, '2021-06-30 18:52:27', '2021-06-30 18:52:27');

-- ----------------------------
-- Table structure for bol_eshop_product_categories
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_product_categories`;
CREATE TABLE `bol_eshop_product_categories`  (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_product_categories
-- ----------------------------
INSERT INTO `bol_eshop_product_categories` VALUES (1, 3);
INSERT INTO `bol_eshop_product_categories` VALUES (2, 1);
INSERT INTO `bol_eshop_product_categories` VALUES (3, 1);

-- ----------------------------
-- Table structure for bol_eshop_products
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_products`;
CREATE TABLE `bol_eshop_products`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `page_view` int(11) NOT NULL DEFAULT 0,
  `view` int(11) NOT NULL DEFAULT 0,
  `sizes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `colors` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `download_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `download_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `brand_id` int(11) NULL DEFAULT NULL,
  `price` decimal(15, 2) NOT NULL,
  `discount` decimal(15, 2) NULL DEFAULT NULL,
  `discount_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `discount_start` datetime(0) NULL DEFAULT NULL,
  `discount_end` datetime(0) NULL DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_products
-- ----------------------------
INSERT INTO `bol_eshop_products` VALUES (1, 'Wifi Smart 4 Gang Touch Switch', 'wifi-smart-4-gang-touch-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1980.00, 5.00, 'Percent', NULL, NULL, 'Wifi Smart 4 Gang Touch Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-24 04:20:00', NULL, '2021-12-03 22:23:16', '2021-12-03 22:27:53', 1);
INSERT INTO `bol_eshop_products` VALUES (2, 'Wifi Smart 3 Gang Touch Switch', 'wifi-smart-3-gang-touch-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, '', 4, 1880.00, 5.00, 'Percent', NULL, NULL, 'Wifi Smart 3 Gang Touch Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-25 04:20:00', NULL, '2021-12-03 22:23:17', '2021-12-03 22:27:53', 1);
INSERT INTO `bol_eshop_products` VALUES (3, 'Wifi Smart 2 Gang Touch Switch', 'wifi-smart-2-gang-touch-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, '', 4, 1780.00, 5.00, 'Percent', NULL, NULL, 'Wifi Smart 2 Gang Touch Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-26 04:20:00', NULL, '2021-12-03 22:23:17', '2021-12-03 22:27:53', 1);
INSERT INTO `bol_eshop_products` VALUES (4, 'Wifi Smart 1 Gang Touch Switch', 'wifi-smart-1-gang-touch-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, '', 4, 1680.00, 5.00, 'Percent', NULL, NULL, 'Wifi Smart 1 Gang Touch Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-27 04:20:00', NULL, '2021-12-03 22:23:17', '2021-12-03 22:27:53', 1);
INSERT INTO `bol_eshop_products` VALUES (5, 'Wifi Smart Fan Switch', 'wifi-smart-fan-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1780.00, 0.00, 'Percent', NULL, NULL, 'Wifi Smart Fan Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-28 04:20:00', NULL, '2021-12-03 22:27:53', '2021-12-03 22:27:53', 1);
INSERT INTO `bol_eshop_products` VALUES (6, 'Wifi Smart Fan and Light Switch', 'wifi-smart-fan-and-light-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1880.00, 0.00, 'Percent', NULL, NULL, 'Wifi Smart Fan and Light Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-29 04:20:00', NULL, '2021-12-03 22:27:53', '2021-12-03 22:27:53', 1);
INSERT INTO `bol_eshop_products` VALUES (7, 'Wifi Smart Light Dimmer Switch', 'wifi-smart-light-dimmer-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1780.00, 0.00, 'Percent', NULL, NULL, 'Wifi Smart Light Dimmer Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-06-30 04:20:00', NULL, '2021-12-03 22:27:54', '2021-12-03 22:27:54', 1);
INSERT INTO `bol_eshop_products` VALUES (8, 'Wifi Smart Geyser Water Heater Switch', 'wifi-smart-geyser-water-heater-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1980.00, 0.00, 'Percent', NULL, NULL, 'Wifi Smart Geyser Water Heater Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-07-01 04:20:00', NULL, '2021-12-03 22:27:54', '2021-12-03 22:27:54', 1);
INSERT INTO `bol_eshop_products` VALUES (9, 'Wifi Smart 5 pin Socket', 'wifi-smart-5-pin-socket', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1980.00, 0.00, 'Percent', NULL, NULL, 'Wifi Smart 5 pin Socket price in Bangladesh', '', 1, 1, 0, 1, '2021-07-02 04:20:00', NULL, '2021-12-03 22:27:54', '2021-12-03 22:27:54', 1);
INSERT INTO `bol_eshop_products` VALUES (10, 'Wifi Smart USB and 5 pin Socket', 'wifi-smart-usb-and-5-pin-socket', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 2080.00, 0.00, 'Percent', NULL, NULL, 'Wifi Smart USB and 5 pin Socket price in Bangladesh', '', 1, 1, 0, 1, '2021-07-03 04:20:00', NULL, '2021-12-03 22:27:54', '2021-12-03 22:27:54', 1);
INSERT INTO `bol_eshop_products` VALUES (11, 'Wifi Smart 3 Pin Plug Socket', 'wifi-smart-3-pin-plug-socket', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '<p>Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.</p>', '', 0, 0, '[]', '[]', NULL, 'Physical Product', NULL, '', 4, 1260.00, 10.00, 'Percent', NULL, NULL, 'Wifi Smart 3 Pin Plug Socket price in Bangladesh', '', 1, 1, 0, 1, '2021-07-04 04:20:00', NULL, '2021-12-03 22:27:55', '2021-12-04 00:24:20', 1);
INSERT INTO `bol_eshop_products` VALUES (12, 'Wifi IR Universal Remote Controller', 'wifi-ir-universal-remote-controller', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1430.00, 0.00, 'Percent', NULL, NULL, 'Wifi IR Universal Remote Controller price in Bangladesh', '', 1, 1, 0, 1, '2021-07-05 04:20:00', NULL, '2021-12-03 22:27:55', '2021-12-03 22:27:55', 1);
INSERT INTO `bol_eshop_products` VALUES (13, 'Wifi Circuit Breaker for different ampere', 'wifi-circuit-breaker-for-different-ampere', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 3800.00, 0.00, 'Percent', NULL, NULL, 'Wifi Circuit Breaker for different ampere price in Bangladesh', '', 1, 1, 0, 1, '2021-07-06 04:20:00', NULL, '2021-12-03 22:27:55', '2021-12-03 22:27:55', 1);
INSERT INTO `bol_eshop_products` VALUES (14, 'Wifi Door Sensor for Open Close Detection', 'wifi-door-sensor-for-open-close-detection', 'Can detect Door Open Close and can control other device with door open close', 'Can detect Door Open Close and can control other device with door open close', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1280.00, 0.00, 'Percent', NULL, NULL, 'Wifi Door Sensor for Open Close Detection price in Bangladesh', '', 1, 1, 0, 1, '2021-07-07 04:20:00', NULL, '2021-12-03 22:27:55', '2021-12-03 22:27:55', 1);
INSERT INTO `bol_eshop_products` VALUES (15, 'Sonoff Wifi Smart Switch', 'sonoff-wifi-smart-switch', 'Wifi smart remote switch work with eWeLink mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with eWeLink mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 580.00, 0.00, 'Percent', NULL, NULL, 'Sonoff Wifi Smart Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-07-08 04:20:00', NULL, '2021-12-03 22:27:55', '2021-12-03 22:27:55', 1);
INSERT INTO `bol_eshop_products` VALUES (16, 'Smart Life Wifi Smart Switch', 'smart-life-wifi-smart-switch', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', 'Wifi smart remote switch work with Tuya/Smart Life mobile app and smart home voice control with google home mini and alexa. Timer Switch, Countdown on/off, Scheduled on/off, Logical on off.', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 580.00, 0.00, 'Percent', NULL, NULL, 'Smart Life Wifi Smart Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-07-09 04:20:00', NULL, '2021-12-03 22:27:56', '2021-12-03 22:27:56', 1);
INSERT INTO `bol_eshop_products` VALUES (17, 'Solid State Relay for Load Control', 'solid-state-relay-for-load-control', 'Solid State Relay for Load Control', 'Solid State Relay for Load Control', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 650.00, 0.00, 'Percent', NULL, NULL, 'Solid State Relay for Load Control price in Bangladesh', '', 1, 1, 0, 1, '2021-07-10 04:20:00', NULL, '2021-12-03 22:27:56', '2021-12-03 22:27:56', 1);
INSERT INTO `bol_eshop_products` VALUES (18, 'Digital Programable Timer Switch', 'digital-programable-timer-switch', 'Digital Programable Timer Switch', 'Digital Programable Timer Switch', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 690.00, 0.00, 'Percent', NULL, NULL, 'Digital Programable Timer Switch price in Bangladesh', '', 1, 1, 0, 1, '2021-07-11 04:20:00', NULL, '2021-12-03 22:27:56', '2021-12-03 22:27:56', 1);
INSERT INTO `bol_eshop_products` VALUES (19, 'USB and 5 pin Socket', 'usb-and-5-pin-socket', 'USB and 5 pin Socket', 'USB and 5 pin Socket', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 450.00, 0.00, 'Percent', NULL, NULL, 'USB and 5 pin Socket price in Bangladesh', '', 1, 1, 0, 1, '2021-07-12 04:20:00', NULL, '2021-12-03 22:27:56', '2021-12-03 22:27:56', 1);
INSERT INTO `bol_eshop_products` VALUES (20, 'Finger Print Drawer Lock', 'finger-print-drawer-lock', 'Finger Print Drawer Lock', 'Finger Print Drawer Lock', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 1660.00, 0.00, 'Percent', NULL, NULL, 'Finger Print Drawer Lock price in Bangladesh', '', 1, 1, 0, 1, '2021-07-13 04:20:00', NULL, '2021-12-03 22:27:56', '2021-12-03 22:27:56', 1);
INSERT INTO `bol_eshop_products` VALUES (21, 'Google Home Mini 2nd Generation', 'google-home-mini-2nd-generation', 'Voice Control Speaker', 'Voice Control Speaker', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 3950.00, 0.00, 'Percent', NULL, NULL, 'Google Home Mini 2nd Generation price in Bangladesh', '', 1, 1, 0, 1, '2021-07-14 04:20:00', NULL, '2021-12-03 22:27:57', '2021-12-03 22:27:57', 1);
INSERT INTO `bol_eshop_products` VALUES (22, 'Alexa Echo Dot 4th Generation without clock', 'alexa-echo-dot-4th-generation-without-clock', 'Voice Control Speaker', 'Voice Control Speaker', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 5500.00, 0.00, 'Percent', NULL, NULL, 'Alexa Echo Dot 4th Generation without clock price in Bangladesh', '', 1, 1, 0, 1, '2021-07-15 04:20:00', NULL, '2021-12-03 22:27:57', '2021-12-03 22:27:57', 1);
INSERT INTO `bol_eshop_products` VALUES (23, 'Alexa Echo Dot 4th Generation with clock', 'alexa-echo-dot-4th-generation-with-clock', 'Voice Control Speaker', 'Voice Control Speaker', '', 0, 0, '[]', '[]', '', 'Physical Product', NULL, NULL, NULL, 8900.00, 0.00, 'Percent', NULL, NULL, 'Alexa Echo Dot 4th Generation with clock price in Bangladesh', '', 1, 1, 0, 1, '2021-07-16 04:20:00', NULL, '2021-12-03 22:27:57', '2021-12-03 22:27:57', 1);

-- ----------------------------
-- Table structure for bol_eshop_shipping_methods
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_shipping_methods`;
CREATE TABLE `bol_eshop_shipping_methods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_shipping_methods
-- ----------------------------
INSERT INTO `bol_eshop_shipping_methods` VALUES (1, 'Receive from front desk', 'receive_from_front_desk', '0', 1, NULL, '2021-06-30 18:53:21', '2021-06-30 18:53:21');

-- ----------------------------
-- Table structure for bol_eshop_unit_list
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_unit_list`;
CREATE TABLE `bol_eshop_unit_list`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bol_eshop_unit_list
-- ----------------------------
INSERT INTO `bol_eshop_unit_list` VALUES (1, 'Pcs');
INSERT INTO `bol_eshop_unit_list` VALUES (2, 'Pair');
INSERT INTO `bol_eshop_unit_list` VALUES (3, 'Kg');

-- ----------------------------
-- Table structure for bol_eshop_wish_list
-- ----------------------------
DROP TABLE IF EXISTS `bol_eshop_wish_list`;
CREATE TABLE `bol_eshop_wish_list`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
