/*
 Navicat Premium Data Transfer

 Source Server         : crm-ssh2
 Source Server Type    : MySQL
 Source Server Version : 100418
 Source Host           : localhost:3306
 Source Schema         : saharertebat

 Target Server Type    : MySQL
 Target Server Version : 100418
 File Encoding         : 65001

 Date: 25/03/2023 15:23:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bnm_banks
-- ----------------------------
DROP TABLE IF EXISTS `bnm_banks`;
CREATE TABLE `bnm_banks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'بدون نام',
  `file_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `file_bank`(`file_id`) USING BTREE,
  CONSTRAINT `file_bank` FOREIGN KEY (`file_id`) REFERENCES `bnm_upload_file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_branch
-- ----------------------------
DROP TABLE IF EXISTS `bnm_branch`;
CREATE TABLE `bnm_branch`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_sherkat` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eghtesadi` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shenase_meli` varchar(32) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_sherkat` int NULL DEFAULT NULL COMMENT 'bnm_company_types',
  `website` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone1` bigint NULL DEFAULT NULL,
  `telephone2` bigint NULL DEFAULT NULL,
  `dornegar` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan` varchar(1) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shahr` varchar(1) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_mohiti` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_tablo` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_code_eghtesadi` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_rozname_tasis` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_shenase_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_akharin_taghirat` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `baladasti_id` int NULL DEFAULT 0,
  `noe_namayandegi` int NULL DEFAULT NULL COMMENT '1=haghighi, 2= hoghoghi',
  `tarikhe_sabt` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_branch_cooperation_type
-- ----------------------------
DROP TABLE IF EXISTS `bnm_branch_cooperation_type`;
CREATE TABLE `bnm_branch_cooperation_type`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `branch_id` int NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `modifier_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `service_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'ADSL(Share)',
  `cooperation_type` int NOT NULL DEFAULT 1 COMMENT '1=darsadi,2=liscence',
  `service_id` int NULL DEFAULT NULL,
  `foroshe_service_jadid` float NOT NULL DEFAULT 0,
  `foroshe_service_sharje_mojadad` float NOT NULL DEFAULT 0,
  `foroshe_service_bulk` float NOT NULL DEFAULT 0,
  `foroshe_service_jashnvare` float NOT NULL DEFAULT 0,
  `hazine_sazmane_tanzim` float NOT NULL DEFAULT 0,
  `hazine_servco` float NOT NULL DEFAULT 0,
  `hazine_mansobe` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_company_types
-- ----------------------------
DROP TABLE IF EXISTS `bnm_company_types`;
CREATE TABLE `bnm_company_types`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_sherkat` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_noe_sherkat` int NULL DEFAULT NULL COMMENT 'tebghe jadvale 1-6 shahkar',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_connection_log
-- ----------------------------
DROP TABLE IF EXISTS `bnm_connection_log`;
CREATE TABLE `bnm_connection_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `postfix` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_countries
-- ----------------------------
DROP TABLE IF EXISTS `bnm_countries`;
CREATE TABLE `bnm_countries`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `code` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 244 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_credits
-- ----------------------------
DROP TABLE IF EXISTS `bnm_credits`;
CREATE TABLE `bnm_credits`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_or_branch_id` int NOT NULL,
  `noe_user` int NOT NULL COMMENT '1=subscriber , 2 = branch',
  `credit` float(21, 2) NOT NULL,
  `bedehkar` float(21, 2) NOT NULL DEFAULT 0.00,
  `bestankar` float(21, 2) NOT NULL DEFAULT 0.00,
  `update_time` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `tozihat` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NULL DEFAULT NULL,
  `change_amount` float(11, 2) NULL DEFAULT NULL,
  `last_row_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2889 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_crmapi
-- ----------------------------
DROP TABLE IF EXISTS `bnm_crmapi`;
CREATE TABLE `bnm_crmapi`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subid` int NOT NULL,
  `fid` int NULL DEFAULT NULL,
  `sertype` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `emakanat_id` int NULL DEFAULT NULL,
  `operation` int NOT NULL,
  `date` date NOT NULL,
  `isfetch` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_crmdailyreportlog
-- ----------------------------
DROP TABLE IF EXISTS `bnm_crmdailyreportlog`;
CREATE TABLE `bnm_crmdailyreportlog`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` int NULL DEFAULT NULL,
  `atarikh` timestamp(6) NULL DEFAULT current_timestamp(6),
  `mtarikh` timestamp(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_customer_speedtest
-- ----------------------------
DROP TABLE IF EXISTS `bnm_customer_speedtest`;
CREATE TABLE `bnm_customer_speedtest`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `ip` varchar(22) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `download` float(8, 2) NOT NULL,
  `upload` float(8, 2) NOT NULL,
  `ping` float(8, 2) NOT NULL,
  `subid` int NOT NULL,
  `userid` int NOT NULL,
  `jitter` float(8, 2) NULL DEFAULT NULL,
  `tarikh` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_dashboard_menu
-- ----------------------------
DROP TABLE IF EXISTS `bnm_dashboard_menu`;
CREATE TABLE `bnm_dashboard_menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `en_name` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `fa_name` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `category_id` int NULL DEFAULT NULL,
  `admin_display` int NULL DEFAULT 0,
  `subscriber_display` int NULL DEFAULT 0,
  `branch2_display` int NULL DEFAULT 0,
  `branch_display` int NULL DEFAULT 0,
  `admin_operator_display` int NULL DEFAULT 0,
  `sort` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cat_id`(`category_id`) USING BTREE,
  CONSTRAINT `bnm_dashboard_menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `bnm_dashboard_menu_category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_dashboard_menu_access
-- ----------------------------
DROP TABLE IF EXISTS `bnm_dashboard_menu_access`;
CREATE TABLE `bnm_dashboard_menu_access`  (
  `menu_id` int NULL DEFAULT NULL,
  `operator_id` int NULL DEFAULT NULL,
  `user_type` int NOT NULL,
  `id` bigint NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `operator_id`(`operator_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 457 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_dashboard_menu_add
-- ----------------------------
DROP TABLE IF EXISTS `bnm_dashboard_menu_add`;
CREATE TABLE `bnm_dashboard_menu_add`  (
  `menu_id` int NULL DEFAULT NULL,
  `operator_id` int NULL DEFAULT NULL,
  `user_type` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `id` bigint NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 467 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_dashboard_menu_category
-- ----------------------------
DROP TABLE IF EXISTS `bnm_dashboard_menu_category`;
CREATE TABLE `bnm_dashboard_menu_category`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `sort` int NOT NULL,
  `icon` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'icon-list2' COMMENT 'html icon class name',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_dashboard_menu_delete
-- ----------------------------
DROP TABLE IF EXISTS `bnm_dashboard_menu_delete`;
CREATE TABLE `bnm_dashboard_menu_delete`  (
  `menu_id` int NULL DEFAULT NULL,
  `operator_id` int NULL DEFAULT NULL,
  `user_type` int NOT NULL,
  `id` bigint NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `operator_id`(`operator_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_dashboard_menu_edit
-- ----------------------------
DROP TABLE IF EXISTS `bnm_dashboard_menu_edit`;
CREATE TABLE `bnm_dashboard_menu_edit`  (
  `menu_id` int NULL DEFAULT NULL,
  `operator_id` int NULL DEFAULT NULL,
  `user_type` int NOT NULL,
  `id` bigint NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 230 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_didban_logs
-- ----------------------------
DROP TABLE IF EXISTS `bnm_didban_logs`;
CREATE TABLE `bnm_didban_logs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `reqname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `reqbody` varchar(300) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `trackingcode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `datets` timestamp NULL DEFAULT current_timestamp,
  `datem` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `resbody` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'body reponse ke ferestade shode',
  `restotalpages` varchar(4) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'kole safahate response',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 130 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_equipments_brands
-- ----------------------------
DROP TABLE IF EXISTS `bnm_equipments_brands`;
CREATE TABLE `bnm_equipments_brands`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_equipments_models
-- ----------------------------
DROP TABLE IF EXISTS `bnm_equipments_models`;
CREATE TABLE `bnm_equipments_models`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `exdate` date NULL DEFAULT NULL,
  `brand_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_factor
-- ----------------------------
DROP TABLE IF EXISTS `bnm_factor`;
CREATE TABLE `bnm_factor`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subscriber_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `emkanat_id` int NULL DEFAULT NULL COMMENT 'wireless (table->sub_station) tdlte (sim_id) adsl (portid) vdsl (portid) voip (subscriber_telephone),bitstream->bnm_oss_reserves',
  `shomare_factor` bigint NULL DEFAULT NULL,
  `modifier_username` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_branch_id` bigint NULL DEFAULT NULL,
  `modifier_id` bigint NULL DEFAULT NULL,
  `sazande_factor_id` int NULL DEFAULT NULL COMMENT 'bnm_users -> id',
  `tarikhe_akharin_virayesh` date NULL DEFAULT NULL,
  `tarikhe_factor` timestamp(6) NULL DEFAULT current_timestamp(6),
  `noe_khadamat` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `onvane_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zamane_estefade` int NULL DEFAULT NULL,
  `tarikhe_shoroe_service` timestamp(6) NULL DEFAULT NULL,
  `tarikhe_payane_service` timestamp(6) NULL DEFAULT NULL,
  `gheymate_service` bigint NULL DEFAULT NULL,
  `takhfif` float(21, 2) NULL DEFAULT NULL,
  `hazine_kharabi` float(12, 2) NULL DEFAULT NULL,
  `hazine_ranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_dranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_nasb` float(12, 2) NULL DEFAULT NULL,
  `abonmane_port` float(12, 2) NULL DEFAULT NULL,
  `abonmane_faza` float(12, 2) NULL DEFAULT NULL,
  `abonmane_tajhizat` float(12, 2) NULL DEFAULT NULL,
  `darsade_avareze_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `maliate_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `pin_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mablaghe_ghabele_pardakht` float(21, 2) NULL DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `terafik` int NULL DEFAULT NULL,
  `zaname_estefade_be_tarikh` date NULL DEFAULT NULL,
  `daryafte_etelaat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ehraze_hoviat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `eneghade_gharardad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_mokhaberat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_ranzhe` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal_sazie_avalie` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_nasb` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `baresie_link` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `sharje_mojadad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_sharje_mojadad` datetime NULL DEFAULT NULL,
  `disable_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `disable_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_disable_shode` timestamp NULL DEFAULT NULL,
  `print_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_print_shode` datetime NULL DEFAULT NULL,
  `ersal_shode` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ersal_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_ersal_shode` datetime NULL DEFAULT NULL,
  `marjo_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_marjo_shode` date NULL DEFAULT NULL,
  `tasvie_shode` int NULL DEFAULT 0,
  `tozihate_disable_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_marjo_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tasvie_konande` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `tarikhe_tasvie_shode` timestamp(6) NULL DEFAULT NULL,
  `tozihate_tasvie_shode` int NULL DEFAULT NULL,
  `ibs_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ibs_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `etebare_baghimande` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `etebare_ghabele_enteghal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `branch_id` int NULL DEFAULT 0,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'adsl',
  `zaname_estefade` int NULL DEFAULT NULL,
  `sazande_factor_username` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sazande_factor_user_type` int NULL DEFAULT NULL,
  `ip_id` int NULL DEFAULT NULL COMMENT 'bnm_ip->id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6996 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_factor2_sorted_beforedelete_tf
-- ----------------------------
DROP TABLE IF EXISTS `bnm_factor2_sorted_beforedelete_tf`;
CREATE TABLE `bnm_factor2_sorted_beforedelete_tf`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subscriber_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `emkanat_id` int NULL DEFAULT NULL COMMENT 'wireless (table->sub_station) tdlte (sim_id) adsl (portid) vdsl (portid) voip (subscriber_telephone),bitstream->bnm_oss_reserves',
  `shomare_factor` bigint NULL DEFAULT NULL,
  `modifier_username` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_branch_id` bigint NULL DEFAULT NULL,
  `modifier_id` bigint NULL DEFAULT NULL,
  `sazande_factor_id` int NULL DEFAULT NULL COMMENT 'bnm_users -> id',
  `tarikhe_akharin_virayesh` date NULL DEFAULT NULL,
  `tarikhe_factor` timestamp(6) NULL DEFAULT current_timestamp(6),
  `noe_khadamat` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `onvane_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zamane_estefade` int NULL DEFAULT NULL,
  `tarikhe_shoroe_service` date NULL DEFAULT NULL,
  `tarikhe_payane_service` date NULL DEFAULT NULL,
  `gheymate_service` bigint NULL DEFAULT NULL,
  `takhfif` float(21, 2) NULL DEFAULT NULL,
  `hazine_kharabi` float(12, 2) NULL DEFAULT NULL,
  `hazine_ranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_dranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_nasb` float(12, 2) NULL DEFAULT NULL,
  `abonmane_port` float(12, 2) NULL DEFAULT NULL,
  `abonmane_faza` float(12, 2) NULL DEFAULT NULL,
  `abonmane_tajhizat` float(12, 2) NULL DEFAULT NULL,
  `darsade_avareze_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `maliate_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `pin_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mablaghe_ghabele_pardakht` float(21, 2) NULL DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `terafik` int NULL DEFAULT NULL,
  `zaname_estefade_be_tarikh` date NULL DEFAULT NULL,
  `daryafte_etelaat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ehraze_hoviat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `eneghade_gharardad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_mokhaberat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_ranzhe` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal_sazie_avalie` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_nasb` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `baresie_link` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `sharje_mojadad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_sharje_mojadad` datetime NULL DEFAULT NULL,
  `disable_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `disable_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_disable_shode` date NULL DEFAULT NULL,
  `print_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_print_shode` datetime NULL DEFAULT NULL,
  `ersal_shode` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ersal_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_ersal_shode` datetime NULL DEFAULT NULL,
  `marjo_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_marjo_shode` date NULL DEFAULT NULL,
  `tasvie_shode` int NULL DEFAULT 0,
  `tozihate_disable_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_marjo_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tasvie_konande` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `tarikhe_tasvie_shode` date NOT NULL,
  `tozihate_tasvie_shode` int NULL DEFAULT NULL,
  `ibs_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ibs_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `etebare_baghimande` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `etebare_ghabele_enteghal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `branch_id` int NULL DEFAULT 0,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'adsl',
  `zaname_estefade` int NULL DEFAULT NULL,
  `sazande_factor_username` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sazande_factor_user_type` int NULL DEFAULT NULL,
  `ip_id` int NULL DEFAULT NULL COMMENT 'bnm_ip->id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4096 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_factor2_stablebutdatalost
-- ----------------------------
DROP TABLE IF EXISTS `bnm_factor2_stablebutdatalost`;
CREATE TABLE `bnm_factor2_stablebutdatalost`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subscriber_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `emkanat_id` int NULL DEFAULT NULL COMMENT 'wireless (table->sub_station) tdlte (sim_id) adsl (portid) vdsl (portid) voip (subscriber_telephone),bitstream->bnm_oss_reserves',
  `shomare_factor` bigint NULL DEFAULT NULL,
  `modifier_username` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_branch_id` bigint NULL DEFAULT NULL,
  `modifier_id` bigint NULL DEFAULT NULL,
  `sazande_factor_id` int NULL DEFAULT NULL COMMENT 'bnm_users -> id',
  `tarikhe_akharin_virayesh` date NULL DEFAULT NULL,
  `tarikhe_factor` timestamp(6) NULL DEFAULT current_timestamp(6),
  `noe_khadamat` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `onvane_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zamane_estefade` int NULL DEFAULT NULL,
  `tarikhe_shoroe_service` date NULL DEFAULT NULL,
  `tarikhe_payane_service` date NULL DEFAULT NULL,
  `gheymate_service` bigint NULL DEFAULT NULL,
  `takhfif` float(21, 2) NULL DEFAULT NULL,
  `hazine_kharabi` float(12, 2) NULL DEFAULT NULL,
  `hazine_ranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_dranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_nasb` float(12, 2) NULL DEFAULT NULL,
  `abonmane_port` float(12, 2) NULL DEFAULT NULL,
  `abonmane_faza` float(12, 2) NULL DEFAULT NULL,
  `abonmane_tajhizat` float(12, 2) NULL DEFAULT NULL,
  `darsade_avareze_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `maliate_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `pin_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mablaghe_ghabele_pardakht` float(21, 2) NULL DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `terafik` int NULL DEFAULT NULL,
  `zaname_estefade_be_tarikh` date NULL DEFAULT NULL,
  `daryafte_etelaat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ehraze_hoviat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `eneghade_gharardad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_mokhaberat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_ranzhe` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal_sazie_avalie` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_nasb` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `baresie_link` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `sharje_mojadad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_sharje_mojadad` datetime NULL DEFAULT NULL,
  `disable_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `disable_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_disable_shode` date NULL DEFAULT NULL,
  `print_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_print_shode` datetime NULL DEFAULT NULL,
  `ersal_shode` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ersal_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_ersal_shode` datetime NULL DEFAULT NULL,
  `marjo_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_marjo_shode` date NULL DEFAULT NULL,
  `tasvie_shode` int NULL DEFAULT 0,
  `tozihate_disable_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_marjo_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tasvie_konande` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `tarikhe_tasvie_shode` date NOT NULL,
  `tozihate_tasvie_shode` int NULL DEFAULT NULL,
  `ibs_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ibs_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `etebare_baghimande` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `etebare_ghabele_enteghal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `branch_id` int NULL DEFAULT 0,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'adsl',
  `zaname_estefade` int NULL DEFAULT NULL,
  `sazande_factor_username` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sazande_factor_user_type` int NULL DEFAULT NULL,
  `ip_id` int NULL DEFAULT NULL COMMENT 'bnm_ip->id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4098 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_factor_naghes
-- ----------------------------
DROP TABLE IF EXISTS `bnm_factor_naghes`;
CREATE TABLE `bnm_factor_naghes`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subscriber_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `emkanat_id` int NULL DEFAULT NULL COMMENT 'wireless (table->sub_station) tdlte (sim_id) adsl (portid) vdsl (portid) voip (subscriber_telephone),bitstream->bnm_oss_reserves',
  `shomare_factor` bigint NULL DEFAULT NULL,
  `modifier_username` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_branch_id` bigint NULL DEFAULT NULL,
  `modifier_id` bigint NULL DEFAULT NULL,
  `sazande_factor_id` int NULL DEFAULT NULL COMMENT 'bnm_users -> id',
  `tarikhe_akharin_virayesh` date NULL DEFAULT NULL,
  `tarikhe_factor` timestamp(6) NULL DEFAULT current_timestamp(6),
  `noe_khadamat` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `onvane_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zamane_estefade` int NULL DEFAULT NULL,
  `tarikhe_shoroe_service` date NULL DEFAULT NULL,
  `tarikhe_payane_service` date NULL DEFAULT NULL,
  `gheymate_service` bigint NULL DEFAULT NULL,
  `takhfif` float(21, 2) NULL DEFAULT NULL,
  `hazine_kharabi` float(12, 2) NULL DEFAULT NULL,
  `hazine_ranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_dranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_nasb` float(12, 2) NULL DEFAULT NULL,
  `abonmane_port` float(12, 2) NULL DEFAULT NULL,
  `abonmane_faza` float(12, 2) NULL DEFAULT NULL,
  `abonmane_tajhizat` float(12, 2) NULL DEFAULT NULL,
  `darsade_avareze_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `maliate_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `pin_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mablaghe_ghabele_pardakht` float(21, 2) NULL DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `terafik` int NULL DEFAULT NULL,
  `zaname_estefade_be_tarikh` date NULL DEFAULT NULL,
  `daryafte_etelaat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ehraze_hoviat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `eneghade_gharardad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_mokhaberat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_ranzhe` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal_sazie_avalie` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_nasb` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `baresie_link` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `sharje_mojadad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_sharje_mojadad` datetime NULL DEFAULT NULL,
  `disable_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `disable_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_disable_shode` date NULL DEFAULT NULL,
  `print_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_print_shode` datetime NULL DEFAULT NULL,
  `ersal_shode` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ersal_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_ersal_shode` datetime NULL DEFAULT NULL,
  `marjo_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_marjo_shode` date NULL DEFAULT NULL,
  `tasvie_shode` int NULL DEFAULT 0,
  `tozihate_disable_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_marjo_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tasvie_konande` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `tarikhe_tasvie_shode` date NOT NULL,
  `tozihate_tasvie_shode` int NULL DEFAULT NULL,
  `ibs_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ibs_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `etebare_baghimande` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `etebare_ghabele_enteghal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `branch_id` int NULL DEFAULT 0,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'adsl',
  `zaname_estefade` int NULL DEFAULT NULL,
  `sazande_factor_username` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sazande_factor_user_type` int NULL DEFAULT NULL,
  `ip_id` int NULL DEFAULT NULL COMMENT 'bnm_ip->id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4096 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_factor_notsortedbeforedelete_copy1
-- ----------------------------
DROP TABLE IF EXISTS `bnm_factor_notsortedbeforedelete_copy1`;
CREATE TABLE `bnm_factor_notsortedbeforedelete_copy1`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subscriber_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `emkanat_id` int NULL DEFAULT NULL COMMENT 'wireless (table->sub_station) tdlte (sim_id) adsl (portid) vdsl (portid) voip (subscriber_telephone),bitstream->bnm_oss_reserves',
  `shomare_factor` bigint NULL DEFAULT NULL,
  `modifier_username` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `modifier_branch_id` bigint NULL DEFAULT NULL,
  `modifier_id` bigint NULL DEFAULT NULL,
  `sazande_factor_id` int NULL DEFAULT NULL COMMENT 'bnm_users -> id',
  `tarikhe_akharin_virayesh` date NULL DEFAULT NULL,
  `tarikhe_factor` timestamp(6) NULL DEFAULT current_timestamp(6),
  `noe_khadamat` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `onvane_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zamane_estefade` int NULL DEFAULT NULL,
  `tarikhe_shoroe_service` date NULL DEFAULT NULL,
  `tarikhe_payane_service` date NULL DEFAULT NULL,
  `gheymate_service` bigint NULL DEFAULT NULL,
  `takhfif` float(21, 2) NULL DEFAULT NULL,
  `hazine_kharabi` float(12, 2) NULL DEFAULT NULL,
  `hazine_ranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_dranzhe` float(12, 2) NULL DEFAULT NULL,
  `hazine_nasb` float(12, 2) NULL DEFAULT NULL,
  `abonmane_port` float(12, 2) NULL DEFAULT NULL,
  `abonmane_faza` float(12, 2) NULL DEFAULT NULL,
  `abonmane_tajhizat` float(12, 2) NULL DEFAULT NULL,
  `darsade_avareze_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `maliate_arzeshe_afzode` float(21, 2) NULL DEFAULT NULL,
  `pin_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mablaghe_ghabele_pardakht` float(21, 2) NULL DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `terafik` int NULL DEFAULT NULL,
  `zaname_estefade_be_tarikh` date NULL DEFAULT NULL,
  `daryafte_etelaat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ehraze_hoviat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `eneghade_gharardad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_mokhaberat` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_ranzhe` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal_sazie_avalie` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `entezare_nasb` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `faal` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `baresie_link` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `sharje_mojadad` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_sharje_mojadad` datetime NULL DEFAULT NULL,
  `disable_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `disable_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_disable_shode` date NULL DEFAULT NULL,
  `print_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `tarikhe_print_shode` datetime NULL DEFAULT NULL,
  `ersal_shode` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `ersal_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_ersal_shode` datetime NULL DEFAULT NULL,
  `marjo_shode` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `marjo_konande` varchar(35) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_marjo_shode` date NULL DEFAULT NULL,
  `tasvie_shode` int NULL DEFAULT 0,
  `tozihate_disable_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_marjo_shode` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tasvie_konande` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `tarikhe_tasvie_shode` date NOT NULL,
  `tozihate_tasvie_shode` int NULL DEFAULT NULL,
  `ibs_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ibs_username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `etebare_baghimande` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `etebare_ghabele_enteghal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '0',
  `branch_id` int NULL DEFAULT 0,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'adsl',
  `zaname_estefade` int NULL DEFAULT NULL,
  `sazande_factor_username` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sazande_factor_user_type` int NULL DEFAULT NULL,
  `ip_id` int NULL DEFAULT NULL COMMENT 'bnm_ip->id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6282 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_host
-- ----------------------------
DROP TABLE IF EXISTS `bnm_host`;
CREATE TABLE `bnm_host`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_service_dahande` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_mojavez` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_tamas` varchar(12) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_poshtibani` varchar(12) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `website` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address_shekayat` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_tarefe` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `dsl_license` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `dsl_bitstream` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `wlan_license` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `wlan_bitstream` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `td_lte` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ngn` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `phone_orgination` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `domain` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `host` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `olaviat` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_internal_messages
-- ----------------------------
DROP TABLE IF EXISTS `bnm_internal_messages`;
CREATE TABLE `bnm_internal_messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `karbord` varchar(12) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `usage`(`karbord`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_ip
-- ----------------------------
DROP TABLE IF EXISTS `bnm_ip`;
CREATE TABLE `bnm_ip`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender` int NULL DEFAULT NULL COMMENT '1=valid,0=invalid',
  `ownership` int NULL DEFAULT NULL COMMENT '1=makel,2=ejare,3=gheyre',
  `iptype` int NULL DEFAULT NULL COMMENT '1=static,dynamic=0',
  `servicetype` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `pool` int NULL DEFAULT NULL COMMENT 'bnm_ip_pool',
  `ipstart` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ipend` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `subnet` int NULL DEFAULT NULL COMMENT 'refrence->bnm_subnetmask',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 360 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_ip_assign
-- ----------------------------
DROP TABLE IF EXISTS `bnm_ip_assign`;
CREATE TABLE `bnm_ip_assign`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ippool` int NOT NULL COMMENT 'bnm_ip_pool_list',
  `ip` int NOT NULL COMMENT 'bnm_ip',
  `sub` int NOT NULL COMMENT 'bnm_subscribers->id\r\n',
  `emkanat_id` int NULL DEFAULT NULL,
  `servicetype` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'koli',
  `taligh` int NULL DEFAULT NULL COMMENT '1=yes,2=no',
  `bandwidth` int NOT NULL,
  `tarikhe_shoroe_ip` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `tarikhe_payane_ip` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `tarikhe_talighe_ip` timestamp(6) NULL DEFAULT NULL,
  `tarikhe_shoroe_service` timestamp(6) NULL DEFAULT NULL COMMENT 'bandwidth->ejbari',
  `tarikhe_payane_service` timestamp(6) NULL DEFAULT NULL COMMENT 'bandwidth->ejbari',
  `tol` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'bandwidth->ejbari',
  `arz` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'bandwidth->ejbari',
  `fid` int NULL DEFAULT NULL COMMENT 'factor id',
  `tarikh` timestamp(6) NULL DEFAULT current_timestamp(6),
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_ip_pool_list
-- ----------------------------
DROP TABLE IF EXISTS `bnm_ip_pool_list`;
CREATE TABLE `bnm_ip_pool_list`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `discription` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_manual_messages
-- ----------------------------
DROP TABLE IF EXISTS `bnm_manual_messages`;
CREATE TABLE `bnm_manual_messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_markaz_mokhaberat
-- ----------------------------
DROP TABLE IF EXISTS `bnm_markaz_mokhaberat`;
CREATE TABLE `bnm_markaz_mokhaberat`  (
  `id` int NOT NULL,
  `ostan` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shahr` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_gharardad` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'onvan3',
  `mizban` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'onvan3',
  `pish_shomare_ostan` int NULL DEFAULT NULL,
  `shomare_tamas_markaz` bigint NULL DEFAULT NULL,
  `shomare_tamas_mdf_markaz` bigint NULL DEFAULT NULL,
  `masire_avale_faktor` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `masire_dovome_faktor` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_messages
-- ----------------------------
DROP TABLE IF EXISTS `bnm_messages`;
CREATE TABLE `bnm_messages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `message_subject` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `type` int NULL DEFAULT NULL COMMENT '1 = payamde az pish tarif shode/2= payame dasti',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1113 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_modir-delete
-- ----------------------------
DROP TABLE IF EXISTS `bnm_modir-delete`;
CREATE TABLE `bnm_modir-delete`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_khanevadegi` varchar(60) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_shenasname` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `madrake_tahsili` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_tahsili` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan_tavalod` int NULL DEFAULT NULL,
  `shahr_tavalod` int NULL DEFAULT NULL,
  `shahr_sokonat` int NULL DEFAULT NULL,
  `ostan_sokonat` int NULL DEFAULT NULL,
  `telephone_hamrah` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_mahale_sokonat` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` varchar(55) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `semat` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_karte_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_shenasname` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_madrake_tahsili` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_chehre` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `level_id` int NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT NULL,
  `panel_status` int NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name_karbari`(`username`) USING BTREE,
  UNIQUE INDEX `unique-username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_noe_terminal
-- ----------------------------
DROP TABLE IF EXISTS `bnm_noe_terminal`;
CREATE TABLE `bnm_noe_terminal`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `esme_terminal` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tedade_port` int NULL DEFAULT NULL,
  `tartibe_ranzhe` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tedade_tighe` int NULL DEFAULT NULL,
  `tedade_port_dar_har_tighe` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_operator
-- ----------------------------
DROP TABLE IF EXISTS `bnm_operator`;
CREATE TABLE `bnm_operator`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `branch_id` int NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_khanevadegi` varchar(60) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_shenasname` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `madrake_tahsili` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_tahsili` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan_tavalod` int NULL DEFAULT NULL,
  `shahr_tavalod` int NULL DEFAULT NULL,
  `ostan_sokonat` int NULL DEFAULT NULL,
  `shahr_sokonat` int NULL DEFAULT NULL,
  `telephone_hamrah` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_mahale_sokonat` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `semat` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_karte_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_shenasname` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_madrake_tahsili` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `t_chehre` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `level_id` int NULL DEFAULT NULL,
  `modir_id` bigint NULL DEFAULT NULL,
  `panel_status` int NULL DEFAULT 1,
  `user_type` int NOT NULL DEFAULT 3,
  `noe_shenase_hoviati` int NULL DEFAULT NULL COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `ismodir` int NULL DEFAULT NULL COMMENT '1=modir asli, 0= not asli ',
  `jensiat` int NULL DEFAULT NULL,
  `code_posti` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `street` varchar(120) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `street2` varchar(120) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `housenumber` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tabaghe` int NULL DEFAULT NULL,
  `vahed` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name_karbari`(`username`) USING BTREE,
  INDEX `namayandegi-operator`(`branch_id`) USING BTREE,
  CONSTRAINT `namayandegi-operator` FOREIGN KEY (`branch_id`) REFERENCES `bnm_branch` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_organization_level
-- ----------------------------
DROP TABLE IF EXISTS `bnm_organization_level`;
CREATE TABLE `bnm_organization_level`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `semat` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `semat`(`semat`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_oss_reserves
-- ----------------------------
DROP TABLE IF EXISTS `bnm_oss_reserves`;
CREATE TABLE `bnm_oss_reserves`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'aval dar oss_subscribers sabt mishavad baad dar in jadval',
  `branch_id` int NULL DEFAULT NULL,
  `oss_id` int NULL DEFAULT NULL COMMENT 'bnm_oss_subscribers refrence',
  `errcode` int NULL DEFAULT NULL,
  `errmsg` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `bitstreamingexpiredate` datetime NULL DEFAULT NULL,
  `bitstreamingpaymentid` int NULL DEFAULT NULL,
  `bitstreamingrequestid` int NULL DEFAULT NULL,
  `bitstreamingresourceid` int NULL DEFAULT NULL,
  `bukht` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `dename` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `lineno` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `phone` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `port` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'oss port',
  `reservestatus` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `resid` int NULL DEFAULT NULL COMMENT 'reserve id in oss',
  `tarikhe_darkhast` datetime(3) NULL DEFAULT NULL,
  `ranzhe` int NULL DEFAULT 0,
  `interfacetype` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NULL DEFAULT 'adsl',
  `reservetime` date NULL DEFAULT NULL,
  `jamavari` int NULL DEFAULT 0,
  `laghv` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 63 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'har moshtaraj aval dar bnm_oss_subscribers sakhte mishavad va bad az reserve dar inja' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_oss_reserves_1401-08-18
-- ----------------------------
DROP TABLE IF EXISTS `bnm_oss_reserves_1401-08-18`;
CREATE TABLE `bnm_oss_reserves_1401-08-18`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'aval dar oss_subscribers sabt mishavad baad dar in jadval',
  `branch_id` int NULL DEFAULT NULL,
  `oss_id` int NULL DEFAULT NULL COMMENT 'bnm_oss_subscribers refrence',
  `errcode` int NULL DEFAULT NULL,
  `errmsg` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `bitstreamingexpiredate` datetime NULL DEFAULT NULL,
  `bitstreamingpaymentid` int NULL DEFAULT NULL,
  `bitstreamingrequestid` int NULL DEFAULT NULL,
  `bitstreamingresourceid` int NULL DEFAULT NULL,
  `bukht` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `dename` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `lineno` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `phone` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `port` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'oss port',
  `reservestatus` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `resid` int NULL DEFAULT NULL COMMENT 'reserve id in oss',
  `tarikhe_darkhast` datetime(3) NULL DEFAULT NULL,
  `ranzhe` int NULL DEFAULT 0,
  `interfacetype` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NULL DEFAULT 'adsl',
  `reservetime` date NULL DEFAULT NULL,
  `jamavari` int NULL DEFAULT 0,
  `laghv` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'har moshtaraj aval dar bnm_oss_subscribers sakhte mishavad va bad az reserve dar inja' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_oss_subscribers
-- ----------------------------
DROP TABLE IF EXISTS `bnm_oss_subscribers`;
CREATE TABLE `bnm_oss_subscribers`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'sakhte moshtarak dar oss in jadval ra por mikonad',
  `user_id` int NULL DEFAULT NULL,
  `telephone` int NULL DEFAULT 1 COMMENT '1=telephone1,2=telephone2,3=telephone3',
  `oss_id` bigint NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL COMMENT '1=faal,2=reserve,3=laghvshode',
  `tarikh` datetime(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_persian_ci COMMENT = 'har moshtaraj aval dar bnm_oss_subscribers sakhte mishavad va bad az reserve dar bnm_oss_reserves' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_oss_tickets
-- ----------------------------
DROP TABLE IF EXISTS `bnm_oss_tickets`;
CREATE TABLE `bnm_oss_tickets`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tiid` int NULL DEFAULT NULL,
  `ossid` int NULL DEFAULT NULL,
  `title` varchar(120) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `maintype` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `maintypeid` int NULL DEFAULT NULL,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `priority` int NULL DEFAULT NULL,
  `ttypeid` int NULL DEFAULT NULL,
  `ownertype` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ownerid` int NULL DEFAULT NULL,
  `source` int NULL DEFAULT NULL,
  `sourcevalue` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sender_userid` int NULL DEFAULT NULL,
  `ticketid` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tiwflowid` int NULL DEFAULT NULL,
  `coordinatorname` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `coordinatormmobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `vspid` int NULL DEFAULT NULL,
  `errcode` int NULL DEFAULT NULL,
  `errmsg` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_ostan
-- ----------------------------
DROP TABLE IF EXISTS `bnm_ostan`;
CREATE TABLE `bnm_ostan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `pish_shomare_ostan` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_ostan_shahkar` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `country_id` int NULL DEFAULT NULL,
  `code_markazeostan` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_atrafemarkazeostan` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_biaban` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_shahrestan` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_atrafeshahrestan` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NULL DEFAULT NULL,
  `name_en` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `latitude` decimal(10, 8) NULL DEFAULT NULL,
  `longitude` decimal(11, 8) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_bnm_ostan`(`country_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_phone_banks
-- ----------------------------
DROP TABLE IF EXISTS `bnm_phone_banks`;
CREATE TABLE `bnm_phone_banks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'بدون نام',
  `city_id` int NULL DEFAULT NULL,
  `file_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_popsite
-- ----------------------------
DROP TABLE IF EXISTS `bnm_popsite`;
CREATE TABLE `bnm_popsite`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_dakal` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `ostan` int NOT NULL,
  `shahr` int NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_dakal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ertefa_sakhteman` float NULL DEFAULT NULL,
  `ertefa_dakal` float NULL DEFAULT NULL,
  `majmoe_ertefa` float NULL DEFAULT NULL,
  `tol_joghrafiai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `arz_joghrafiai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_malekiat_dakal` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'استیجاری یا مالکیت',
  `malek_dakal` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_khanevadegi_malek` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `rotbe_dakal` varchar(1) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mizban_dakal` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_postiban_dakal` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_khanevadegi_poshtiban_dakal` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_poshtiban` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ejare_mahiane_nasbe_anten_roye_dakal` int NULL DEFAULT NULL,
  `bime_dakal` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `cheragh_dakal` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `bargh_ezterari` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `batri_poshtiban` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ert` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `emkane_nasbe_anten` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ejaze_dastresi24_saate_dakal` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `masire_avale_faktore_dakal` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `masire_dovome_faktore_dakal` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `maleke_dakal` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_tamas_malek` varchar(12) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_poshtiban` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_malekiat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mizbane_dakal` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `family_poshtiban` varchar(60) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shoamre_tamas_poshtiban` varchar(12) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `masire_avale_faktorha` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `barghe_ezterari` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `batrie_poshtiban` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `cheraghe_dakal` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ejaze_dastresi_24_saate` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_port
-- ----------------------------
DROP TABLE IF EXISTS `bnm_port`;
CREATE TABLE `bnm_port`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `terminal` int NULL DEFAULT NULL,
  `etesal` bigint NULL DEFAULT NULL,
  `tighe` bigint NULL DEFAULT NULL,
  `port` bigint NULL DEFAULT NULL,
  `kart` bigint NULL DEFAULT NULL,
  `dslam` bigint NULL DEFAULT NULL,
  `telephone` varchar(25) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `adsl_vdsl` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `radif` int NOT NULL,
  `ostan` int NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `markaze_mokhaberati` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL COMMENT 'subscriber_id',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `port_subscriber`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 681 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_pre_number
-- ----------------------------
DROP TABLE IF EXISTS `bnm_pre_number`;
CREATE TABLE `bnm_pre_number`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenumber` varchar(8) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `markaze_mokhaberati` int NULL DEFAULT NULL,
  `tozihat` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_pre_number_delete
-- ----------------------------
DROP TABLE IF EXISTS `bnm_pre_number_delete`;
CREATE TABLE `bnm_pre_number_delete`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `markaze_mokhaberati` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tedade_pishshomare` int NULL DEFAULT NULL,
  `mantaghe` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan` varchar(1) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shahr` varchar(1) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mizban` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sarshomare` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_gharardad` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihat` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_send_sms_requests
-- ----------------------------
DROP TABLE IF EXISTS `bnm_send_sms_requests`;
CREATE TABLE `bnm_send_sms_requests`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `receiver` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'phone number or bank_id',
  `start_date` date NULL DEFAULT NULL,
  `end_date` date NULL DEFAULT NULL,
  `receiver_type` int NULL DEFAULT 1 COMMENT '1=single send & 2= group send',
  `message_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2411 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_sep_payment
-- ----------------------------
DROP TABLE IF EXISTS `bnm_sep_payment`;
CREATE TABLE `bnm_sep_payment`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `resnum` bigint NULL DEFAULT NULL,
  `refnum` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `state` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ok = pardakht be dorosti anjam shode',
  `user_id` int NULL DEFAULT NULL,
  `user_type` int NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT NULL,
  `tarikhe_pardakht` timestamp NULL DEFAULT current_timestamp,
  `amount` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `merchantcode` int NULL DEFAULT NULL COMMENT 'merchantcode= terminalid',
  `traceno` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rrn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `securepan` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mid` int NULL DEFAULT NULL,
  `http_c_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `http_x_f_f_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remote_addr_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  `hashedcardnumber` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dargah` int NULL DEFAULT NULL,
  `authority` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `res_num`(`resnum`) USING BTREE,
  INDEX `ref_num`(`refnum`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_sep_resnum_pool
-- ----------------------------
DROP TABLE IF EXISTS `bnm_sep_resnum_pool`;
CREATE TABLE `bnm_sep_resnum_pool`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `resnum` bigint NULL DEFAULT NULL COMMENT 'shomare tarakonesh banke saman(resnum)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_services
-- ----------------------------
DROP TABLE IF EXISTS `bnm_services`;
CREATE TABLE `bnm_services`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_khadamat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'ADSL(Share)',
  `namayeshe_service` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `namayeshe_dar_profile` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `onvane_service` varchar(55) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zaname_estefade` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `takhfif` float NULL DEFAULT NULL,
  `name_service_dahande` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `porsant` float NULL DEFAULT NULL,
  `tarikhe_shoroe_namayesh` date NULL DEFAULT NULL,
  `tarikhe_payane_namayesh` date NULL DEFAULT NULL,
  `emtiaze_jayeze` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `hadeaghale_emtiaz` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `hadeaksare_emtiaz` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mablaghe_har_emtiaz` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_grohe_moshtari` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_groh` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `range_namayeshe_profile` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `range_vizhesazie_profile` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `saat_vasle_movaghat` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `roze_vasle_movaghat` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `terafike_vasle_movaghat` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `dore_be_mah` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `dore_be_saat` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `terafik` bigint NULL DEFAULT NULL,
  `hazine_nasb` bigint NULL DEFAULT NULL,
  `hazine_dranzhe` bigint NULL DEFAULT NULL,
  `hazine_kharabi` bigint NULL DEFAULT NULL,
  `hazine_ranzhe` bigint NULL DEFAULT NULL,
  `tozihate_faktor` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_website` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `sorate_paye_daryaft` float NULL DEFAULT NULL,
  `hadeaxar_sorat_daryaft` float NULL DEFAULT NULL,
  `sorat_paye_ersal` float NULL DEFAULT NULL,
  `port` int NULL DEFAULT NULL,
  `tajhizat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `faza` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `type` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_pardakht` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `gheymat` bigint NULL DEFAULT NULL,
  `dore_be_rooz` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `zaname_estefade_be_tarikh` datetime NULL DEFAULT NULL,
  `noe_forosh` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'adi',
  `tedad` int NULL DEFAULT NULL,
  `shenase_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `seriale_service` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 251 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_services_contract
-- ----------------------------
DROP TABLE IF EXISTS `bnm_services_contract`;
CREATE TABLE `bnm_services_contract`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `contract_subject` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `contract_content` mediumtext CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `service_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `service_type`(`service_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_shahkar_config
-- ----------------------------
DROP TABLE IF EXISTS `bnm_shahkar_config`;
CREATE TABLE `bnm_shahkar_config`  (
  `url` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'amniat',
  `username` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'sahar_ertebat' COMMENT 'amniat',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'amniat',
  `serverurl` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'local',
  `id` int NOT NULL DEFAULT 1,
  `providercode` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT '0262' COMMENT 'amniat',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_shahr
-- ----------------------------
DROP TABLE IF EXISTS `bnm_shahr`;
CREATE TABLE `bnm_shahr`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `ostan_id` int NULL DEFAULT NULL,
  `name_en` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `latitude` decimal(10, 8) NULL DEFAULT NULL,
  `longitude` decimal(11, 8) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ostan_id`(`ostan_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 483 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_siamconfig
-- ----------------------------
DROP TABLE IF EXISTS `bnm_siamconfig`;
CREATE TABLE `bnm_siamconfig`  (
  `id` int NOT NULL,
  `username` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tarikhe_akharin_virayesh` timestamp(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_sms
-- ----------------------------
DROP TABLE IF EXISTS `bnm_sms`;
CREATE TABLE `bnm_sms`  (
  `id` int NOT NULL,
  `send_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'sms',
  `receiver_type` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_sms_queue
-- ----------------------------
DROP TABLE IF EXISTS `bnm_sms_queue`;
CREATE TABLE `bnm_sms_queue`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `receiver` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sender` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `request_id` int NOT NULL,
  `status_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status_message` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6898 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_sub_contract
-- ----------------------------
DROP TABLE IF EXISTS `bnm_sub_contract`;
CREATE TABLE `bnm_sub_contract`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subid` int NULL DEFAULT NULL COMMENT 'bnm_subscriber',
  `contractid` int NULL DEFAULT NULL COMMENT 'bnm_display_contract',
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL COMMENT '1=signed,0=unsigned',
  `tarikh` datetime(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_sub_station
-- ----------------------------
DROP TABLE IF EXISTS `bnm_sub_station`;
CREATE TABLE `bnm_sub_station`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_id` int NULL DEFAULT NULL COMMENT 'refrence->bnm_subscriber',
  `station_id` int NULL DEFAULT NULL COMMENT 'refrence->bnm_station',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_subinfoupdatelogs
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subinfoupdatelogs`;
CREATE TABLE `bnm_subinfoupdatelogs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subid` int NULL DEFAULT NULL,
  `atarikh` timestamp(6) NULL DEFAULT current_timestamp(6),
  `mtarikh` timestamp(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2038 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_subnetmask
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subnetmask`;
CREATE TABLE `bnm_subnetmask`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subnet` int NULL DEFAULT NULL,
  `subnet_value` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_subscribers
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subscribers`;
CREATE TABLE `bnm_subscribers`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_moshtarak` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'real',
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `f_name` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `jensiat` int NULL DEFAULT NULL COMMENT '1= mard, 2= zan',
  `meliat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `tabeiat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `noe_shenase_hoviati` int NOT NULL DEFAULT 0 COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shomare_shenasname` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `ostane_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_ostan->id',
  `shahre_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_shahr->id',
  `telephone1` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_hamrah` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `fax` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `website` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `code_posti1` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti2` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti3` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address2` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address3` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `shoghl` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `nahve_ashnai` int NULL DEFAULT NULL,
  `gorohe_moshtarak` int NULL DEFAULT NULL,
  `moaref` int NULL DEFAULT NULL,
  `tozihat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_karte_meli` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ejare_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `name_sherkat` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_dakheli` int NULL DEFAULT NULL,
  `code_eghtesadi` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shenase_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedare` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_faaliat` int NULL DEFAULT NULL,
  `l_t_agahie_tasis` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_akharin_taghirat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_aval` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_dovom` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_kartemeli_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_moarefiname_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ejarename_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `telephone2` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone3` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT 0,
  `noe_malekiat1` int NULL DEFAULT 1,
  `noe_malekiat2` int NULL DEFAULT 1,
  `noe_malekiat3` int NULL DEFAULT 1 COMMENT '1=malek,0=mostajer',
  `name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_sherkat` int NULL DEFAULT NULL COMMENT 'refrence -> bnm_company_types(tebghe jadvale 1-6 shahkar)',
  `code_faragire_haghighi_pezhvak` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabte_sherkat` date NULL DEFAULT NULL,
  `shenase_hoviati_sherkat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_namayande_forosh` int NULL DEFAULT NULL,
  `telephone_hamrahe_sherkat` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_shenase_hoviati_sherkat` int NOT NULL COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shahre_sokonat` int NULL DEFAULT NULL,
  `ostane_sokonat` int NULL DEFAULT NULL,
  `tarikhe_tavalod_namayande` date NULL DEFAULT NULL,
  `code_pezhvak` int NULL DEFAULT NULL COMMENT 'code haghighi pezhvak',
  `meliat_namayande` int NULL DEFAULT NULL,
  `tel1_ostan` int NULL DEFAULT NULL,
  `tel2_ostan` int NULL DEFAULT NULL,
  `tel3_ostan` int NULL DEFAULT NULL,
  `tel1_shahr` int NULL DEFAULT NULL,
  `tel2_shahr` int NULL DEFAULT NULL,
  `tel3_shahr` int NULL DEFAULT NULL,
  `tel1_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_tabaghe` int NULL DEFAULT NULL,
  `tel2_tabaghe` int NULL DEFAULT NULL,
  `tel3_tabaghe` int NULL DEFAULT NULL,
  `tel1_vahed` int NULL DEFAULT NULL,
  `tel2_vahed` int NULL DEFAULT NULL,
  `tel3_vahed` int NULL DEFAULT NULL,
  `tarikhe_sabtenam` timestamp(6) NULL DEFAULT current_timestamp(6),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UK_bnm_subscribers_code_eshterak`(`code_eshterak`) USING BTREE,
  INDEX `code_eshterak`(`code_eshterak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3034 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_subscribers-beforeswitchingtable
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subscribers-beforeswitchingtable`;
CREATE TABLE `bnm_subscribers-beforeswitchingtable`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_moshtarak` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'real',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `f_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `jensiat` int NULL DEFAULT NULL COMMENT '1= mard, 2= zan',
  `meliat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `tabeiat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `noe_shenase_hoviati` int NOT NULL DEFAULT 0 COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shomare_shenasname` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `ostane_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_ostan->id',
  `shahre_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_shahr->id',
  `telephone1` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_hamrah` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `fax` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `website` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `code_posti1` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti2` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti3` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address2` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address3` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `shoghl` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `nahve_ashnai` int NULL DEFAULT NULL,
  `gorohe_moshtarak` int NULL DEFAULT NULL,
  `moaref` int NULL DEFAULT NULL,
  `tozihat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_karte_meli` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ejare_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `name_sherkat` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_dakheli` int NULL DEFAULT NULL,
  `code_eghtesadi` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shenase_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedare` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_faaliat` int NULL DEFAULT NULL,
  `l_t_agahie_tasis` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_akharin_taghirat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_aval` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_dovom` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_kartemeli_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_moarefiname_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ejarename_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `telephone2` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone3` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT 0,
  `noe_malekiat1` int NULL DEFAULT 1,
  `noe_malekiat2` int NULL DEFAULT 1,
  `noe_malekiat3` int NULL DEFAULT 1 COMMENT '1=malek,0=mostajer',
  `name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_sherkat` int NULL DEFAULT NULL COMMENT 'refrence -> bnm_company_types(tebghe jadvale 1-6 shahkar)',
  `code_faragire_haghighi_pezhvak` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabte_sherkat` date NULL DEFAULT NULL,
  `shenase_hoviati_sherkat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_namayande_forosh` int NULL DEFAULT NULL,
  `telephone_hamrahe_sherkat` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_shenase_hoviati_sherkat` int NOT NULL COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shahre_sokonat` int NULL DEFAULT NULL,
  `ostane_sokonat` int NULL DEFAULT NULL,
  `tarikhe_tavalod_namayande` date NULL DEFAULT NULL,
  `code_pezhvak` int NULL DEFAULT NULL COMMENT 'code haghighi pezhvak',
  `meliat_namayande` int NULL DEFAULT NULL,
  `tel1_ostan` int NULL DEFAULT NULL,
  `tel2_ostan` int NULL DEFAULT NULL,
  `tel3_ostan` int NULL DEFAULT NULL,
  `tel1_shahr` int NULL DEFAULT NULL,
  `tel2_shahr` int NULL DEFAULT NULL,
  `tel3_shahr` int NULL DEFAULT NULL,
  `tel1_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_tabaghe` int NULL DEFAULT NULL,
  `tel2_tabaghe` int NULL DEFAULT NULL,
  `tel3_tabaghe` int NULL DEFAULT NULL,
  `tel1_vahed` int NULL DEFAULT NULL,
  `tel2_vahed` int NULL DEFAULT NULL,
  `tel3_vahed` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UK_bnm_subscribers_code_eshterak`(`code_eshterak`) USING BTREE,
  INDEX `code_eshterak`(`code_eshterak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2123 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_subscribers2_copy1
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subscribers2_copy1`;
CREATE TABLE `bnm_subscribers2_copy1`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_moshtarak` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'real',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `f_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `jensiat` int NULL DEFAULT NULL COMMENT '1= mard, 2= zan',
  `meliat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `tabeiat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `noe_shenase_hoviati` int NOT NULL DEFAULT 0 COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shomare_shenasname` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `ostane_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_ostan->id',
  `shahre_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_shahr->id',
  `telephone1` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_hamrah` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `fax` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `website` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `code_posti1` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti2` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti3` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address2` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address3` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `shoghl` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `nahve_ashnai` int NULL DEFAULT NULL,
  `gorohe_moshtarak` int NULL DEFAULT NULL,
  `moaref` int NULL DEFAULT NULL,
  `tozihat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_karte_meli` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ejare_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `name_sherkat` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_dakheli` int NULL DEFAULT NULL,
  `code_eghtesadi` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shenase_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedare` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_faaliat` int NULL DEFAULT NULL,
  `l_t_agahie_tasis` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_akharin_taghirat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_aval` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_dovom` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_kartemeli_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_moarefiname_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ejarename_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `telephone2` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone3` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT 0,
  `noe_malekiat1` int NULL DEFAULT 1,
  `noe_malekiat2` int NULL DEFAULT 1,
  `noe_malekiat3` int NULL DEFAULT 1 COMMENT '1=malek,0=mostajer',
  `name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_sherkat` int NULL DEFAULT NULL COMMENT 'refrence -> bnm_company_types(tebghe jadvale 1-6 shahkar)',
  `code_faragire_haghighi_pezhvak` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabte_sherkat` date NULL DEFAULT NULL,
  `shenase_hoviati_sherkat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_namayande_forosh` int NULL DEFAULT NULL,
  `telephone_hamrahe_sherkat` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_shenase_hoviati_sherkat` int NOT NULL COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shahre_sokonat` int NULL DEFAULT NULL,
  `ostane_sokonat` int NULL DEFAULT NULL,
  `tarikhe_tavalod_namayande` date NULL DEFAULT NULL,
  `code_pezhvak` int NULL DEFAULT NULL COMMENT 'code haghighi pezhvak',
  `meliat_namayande` int NULL DEFAULT NULL,
  `tel1_ostan` int NULL DEFAULT NULL,
  `tel2_ostan` int NULL DEFAULT NULL,
  `tel3_ostan` int NULL DEFAULT NULL,
  `tel1_shahr` int NULL DEFAULT NULL,
  `tel2_shahr` int NULL DEFAULT NULL,
  `tel3_shahr` int NULL DEFAULT NULL,
  `tel1_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_tabaghe` int NULL DEFAULT NULL,
  `tel2_tabaghe` int NULL DEFAULT NULL,
  `tel3_tabaghe` int NULL DEFAULT NULL,
  `tel1_vahed` int NULL DEFAULT NULL,
  `tel2_vahed` int NULL DEFAULT NULL,
  `tel3_vahed` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UK_bnm_subscribers_code_eshterak`(`code_eshterak`) USING BTREE,
  INDEX `code_eshterak`(`code_eshterak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2839 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_subscribers_copy1
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subscribers_copy1`;
CREATE TABLE `bnm_subscribers_copy1`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_moshtarak` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'real',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `f_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `jensiat` int NULL DEFAULT NULL COMMENT '1= mard, 2= zan',
  `meliat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `tabeiat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `noe_shenase_hoviati` int NOT NULL DEFAULT 0 COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shomare_shenasname` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `ostane_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_ostan->id',
  `shahre_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_shahr->id',
  `telephone1` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_hamrah` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `fax` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `website` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `code_posti1` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti2` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti3` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address2` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address3` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `shoghl` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `nahve_ashnai` int NULL DEFAULT NULL,
  `gorohe_moshtarak` int NULL DEFAULT NULL,
  `moaref` int NULL DEFAULT NULL,
  `tozihat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_karte_meli` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ejare_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `name_sherkat` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_dakheli` int NULL DEFAULT NULL,
  `code_eghtesadi` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shenase_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedare` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_faaliat` int NULL DEFAULT NULL,
  `l_t_agahie_tasis` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_akharin_taghirat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_aval` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_dovom` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_kartemeli_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_moarefiname_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ejarename_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `telephone2` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone3` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT 0,
  `noe_malekiat1` int NULL DEFAULT 1,
  `noe_malekiat2` int NULL DEFAULT 1,
  `noe_malekiat3` int NULL DEFAULT 1 COMMENT '1=malek,0=mostajer',
  `name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_sherkat` int NULL DEFAULT NULL COMMENT 'refrence -> bnm_company_types(tebghe jadvale 1-6 shahkar)',
  `code_faragire_haghighi_pezhvak` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabte_sherkat` date NULL DEFAULT NULL,
  `shenase_hoviati_sherkat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_namayande_forosh` int NULL DEFAULT NULL,
  `telephone_hamrahe_sherkat` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_shenase_hoviati_sherkat` int NOT NULL COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shahre_sokonat` int NULL DEFAULT NULL,
  `ostane_sokonat` int NULL DEFAULT NULL,
  `tarikhe_tavalod_namayande` date NULL DEFAULT NULL,
  `code_pezhvak` int NULL DEFAULT NULL COMMENT 'code haghighi pezhvak',
  `meliat_namayande` int NULL DEFAULT NULL,
  `tel1_ostan` int NULL DEFAULT NULL,
  `tel2_ostan` int NULL DEFAULT NULL,
  `tel3_ostan` int NULL DEFAULT NULL,
  `tel1_shahr` int NULL DEFAULT NULL,
  `tel2_shahr` int NULL DEFAULT NULL,
  `tel3_shahr` int NULL DEFAULT NULL,
  `tel1_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_tabaghe` int NULL DEFAULT NULL,
  `tel2_tabaghe` int NULL DEFAULT NULL,
  `tel3_tabaghe` int NULL DEFAULT NULL,
  `tel1_vahed` int NULL DEFAULT NULL,
  `tel2_vahed` int NULL DEFAULT NULL,
  `tel3_vahed` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UK_bnm_subscribers_code_eshterak`(`code_eshterak`) USING BTREE,
  INDEX `code_eshterak`(`code_eshterak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 792 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_subscribers_copy2
-- ----------------------------
DROP TABLE IF EXISTS `bnm_subscribers_copy2`;
CREATE TABLE `bnm_subscribers_copy2`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_moshtarak` varchar(5) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'real',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `f_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `jensiat` int NULL DEFAULT NULL COMMENT '1= mard, 2= zan',
  `meliat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `tabeiat` int NULL DEFAULT 1 COMMENT 'bnm_countries',
  `noe_shenase_hoviati` int NOT NULL DEFAULT 0 COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shomare_shenasname` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_tavalod` date NULL DEFAULT NULL,
  `ostane_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_ostan->id',
  `shahre_tavalod` int NULL DEFAULT NULL COMMENT 'bnm_shahr->id',
  `telephone1` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_hamrah` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `fax` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `website` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `code_posti1` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti2` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_posti3` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address2` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `address3` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `shoghl` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `nahve_ashnai` int NULL DEFAULT NULL,
  `gorohe_moshtarak` int NULL DEFAULT NULL,
  `moaref` int NULL DEFAULT NULL,
  `tozihat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_karte_meli` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_ejare_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `r_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `name_sherkat` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_sabt` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_dakheli` int NULL DEFAULT NULL,
  `code_eghtesadi` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shenase_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedare` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `reshteye_faaliat` int NULL DEFAULT NULL,
  `l_t_agahie_tasis` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_akharin_taghirat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_aval` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_saheb_kartemeli_emzaye_dovom` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_kartemeli_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_moarefiname_namayande` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ghabze_telephone` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_gharardad` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_ejarename_malekiat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `l_t_sayer` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `telephone2` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone3` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_eshterak` bigint NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT 0,
  `noe_malekiat1` int NULL DEFAULT 1,
  `noe_malekiat2` int NULL DEFAULT 1,
  `noe_malekiat3` int NULL DEFAULT 1 COMMENT '1=malek,0=mostajer',
  `name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek1` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek2` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli_malek3` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_sherkat` int NULL DEFAULT NULL COMMENT 'refrence -> bnm_company_types(tebghe jadvale 1-6 shahkar)',
  `code_faragire_haghighi_pezhvak` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_sabte_sherkat` date NULL DEFAULT NULL,
  `shenase_hoviati_sherkat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_namayande_forosh` int NULL DEFAULT NULL,
  `telephone_hamrahe_sherkat` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_shenase_hoviati_sherkat` int NOT NULL COMMENT '0=code meli, 1= gozarname, 2= amayesh, 3= panahandegi, 4= hoviat, 5=shenase meli, 6= shomare faragire gozarname',
  `shahre_sokonat` int NULL DEFAULT NULL,
  `ostane_sokonat` int NULL DEFAULT NULL,
  `tarikhe_tavalod_namayande` date NULL DEFAULT NULL,
  `code_pezhvak` int NULL DEFAULT NULL COMMENT 'code haghighi pezhvak',
  `meliat_namayande` int NULL DEFAULT NULL,
  `tel1_ostan` int NULL DEFAULT NULL,
  `tel2_ostan` int NULL DEFAULT NULL,
  `tel3_ostan` int NULL DEFAULT NULL,
  `tel1_shahr` int NULL DEFAULT NULL,
  `tel2_shahr` int NULL DEFAULT NULL,
  `tel3_shahr` int NULL DEFAULT NULL,
  `tel1_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_street2` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel2_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel3_housenumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel1_tabaghe` int NULL DEFAULT NULL,
  `tel2_tabaghe` int NULL DEFAULT NULL,
  `tel3_tabaghe` int NULL DEFAULT NULL,
  `tel1_vahed` int NULL DEFAULT NULL,
  `tel2_vahed` int NULL DEFAULT NULL,
  `tel3_vahed` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `UK_bnm_subscribers_code_eshterak`(`code_eshterak`) USING BTREE,
  INDEX `code_eshterak`(`code_eshterak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2839 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_support_requests
-- ----------------------------
DROP TABLE IF EXISTS `bnm_support_requests`;
CREATE TABLE `bnm_support_requests`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `noe_payam` int NULL DEFAULT 1 COMMENT '1=pishtibani,2=sla,3=jamavari,4=sayer',
  `onvane_payam` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'بدون عنوان',
  `matne_payam` text CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `sender_user_id` bigint NULL DEFAULT NULL,
  `sender_branch_id` int NULL DEFAULT NULL,
  `sender_id` int NULL DEFAULT NULL,
  `sender_user_type` int NULL DEFAULT NULL,
  `read_status_user` int NULL DEFAULT 0,
  `read_status_branch` int NULL DEFAULT 0,
  `read_status_admin` int NULL DEFAULT 1,
  `reciever_user_id` int NULL DEFAULT NULL,
  `reciever_user_type` int NULL DEFAULT 5,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_suspensions
-- ----------------------------
DROP TABLE IF EXISTS `bnm_suspensions`;
CREATE TABLE `bnm_suspensions`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subid` int NULL DEFAULT NULL,
  `servicetype` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `emkanatid` int NULL DEFAULT NULL,
  `datetime_auto` timestamp(6) NULL DEFAULT current_timestamp(6),
  `factorid` int NULL DEFAULT NULL,
  `modat` int NULL DEFAULT NULL COMMENT '0=bedone tarikh',
  `lockstatus` int NULL DEFAULT NULL COMMENT '1=lock, 2= unlock',
  `lock_datetime` timestamp(6) NULL DEFAULT NULL,
  `unlock_datetime` timestamp(6) NULL DEFAULT NULL,
  `tozihate_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tozihate_unlock` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_tajhizate_standard
-- ----------------------------
DROP TABLE IF EXISTS `bnm_tajhizate_standard`;
CREATE TABLE `bnm_tajhizate_standard`  (
  `id` int NOT NULL,
  `mark` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `model` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `keshvare_sazande` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarihke_sodor` datetime(6) NOT NULL,
  `tarikhe_payan` datetime(6) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_tax
-- ----------------------------
DROP TABLE IF EXISTS `bnm_tax`;
CREATE TABLE `bnm_tax`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `darsade_arzeshe_afzode` float NULL DEFAULT NULL,
  `darsade_maliate_arzeshe_afzode` float NULL DEFAULT NULL,
  `darsade_avarez_arzeshe_afzode` float NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_tdlte_sim
-- ----------------------------
DROP TABLE IF EXISTS `bnm_tdlte_sim`;
CREATE TABLE `bnm_tdlte_sim`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `puk1` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `puk2` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tdlte_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT 0,
  `subscriber_id` int NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `factor_id` int NULL DEFAULT NULL,
  `tol_joghrafiai` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `arz_joghrafiai` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 102 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_telecommunications_center
-- ----------------------------
DROP TABLE IF EXISTS `bnm_telecommunications_center`;
CREATE TABLE `bnm_telecommunications_center`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shahr` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `pish_shomare_ostan` varchar(8) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `shomare_tamas_markaz` varchar(20) CHARACTER SET utf32 COLLATE utf32_persian_ci NULL DEFAULT NULL,
  `shomare_tamas_mdf` varchar(20) CHARACTER SET utf32 COLLATE utf32_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `masire_avale_faktorha` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `masire_dovome_faktorha` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mizban` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_gharardad` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mizban_id` int NULL DEFAULT NULL,
  `ip_ppoe_server` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `user_ppoe_server` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `snmp_ppoe_server` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `password_ppoe_server` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tedade_pish_shomare` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_terminal
-- ----------------------------
DROP TABLE IF EXISTS `bnm_terminal`;
CREATE TABLE `bnm_terminal`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ostan` int NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `markaze_mokhaberati` int NULL DEFAULT NULL,
  `noe_terminal` int NULL DEFAULT NULL,
  `tighe` int NULL DEFAULT NULL,
  `shoroe_etesali` int NULL DEFAULT NULL,
  `radif` int NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ostan`(`ostan`) USING BTREE,
  INDEX `shahr`(`shahr`) USING BTREE,
  INDEX `markaze_mokhaberati`(`markaze_mokhaberati`) USING BTREE,
  INDEX `noe_terminal`(`noe_terminal`) USING BTREE,
  CONSTRAINT `bnm_terminal_ibfk_2` FOREIGN KEY (`markaze_mokhaberati`) REFERENCES `bnm_telecommunications_center` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_upload_file
-- ----------------------------
DROP TABLE IF EXISTS `bnm_upload_file`;
CREATE TABLE `bnm_upload_file`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `usage_type` int NOT NULL,
  `file_subject` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT 'بدون عنوان',
  `file_path` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `uploader_user_type` int NULL DEFAULT NULL,
  `uploader_id` bigint NULL DEFAULT NULL,
  `uploader_username` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikhe_upload` datetime NULL DEFAULT NULL,
  `file_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_users
-- ----------------------------
DROP TABLE IF EXISTS `bnm_users`;
CREATE TABLE `bnm_users`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'md5 hash',
  `user_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT '1=admin & 2 = namayande Lvl1 & 3 = namayande1 operator & 4 = admin_operator & 5=subscriber & 6 = namayande Lvl2 & 7= namayande2 operator',
  `branch_id` int NULL DEFAULT NULL,
  `user_id` bigint NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_khanevadegi` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `semat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT 1 COMMENT '1= faal , 2= gheyre faal',
  `baladasti_id` int NULL DEFAULT 0 COMMENT 'id namayande baladasti ke agar sherkat bashad 0 mizarim',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1006 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_users_copy1
-- ----------------------------
DROP TABLE IF EXISTS `bnm_users_copy1`;
CREATE TABLE `bnm_users_copy1`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT 'md5 hash',
  `user_type` varchar(6) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL COMMENT '1=admin & 2 = namayande Lvl1 & 3 = namayande1 operator & 4 = admin_operator & 5=subscriber & 6 = namayande Lvl2 & 7= namayande2 operator',
  `branch_id` int NULL DEFAULT NULL,
  `user_id` bigint NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_khanevadegi` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `semat` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` int NULL DEFAULT 1 COMMENT '1= faal , 2= gheyre faal',
  `baladasti_id` int NULL DEFAULT 0 COMMENT 'id namayande baladasti ke agar sherkat bashad 0 mizarim',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1001 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bnm_wireless_ap
-- ----------------------------
DROP TABLE IF EXISTS `bnm_wireless_ap`;
CREATE TABLE `bnm_wireless_ap`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tarikhe_payan` date NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_link_sabt_samane` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `popsite` int NULL DEFAULT NULL COMMENT 'tarif1',
  `shenase_dakal` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan` int NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `tol_joghrafiai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `arz_joghrafiai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ertefae_sakhteman` float NULL DEFAULT NULL,
  `ertefae_dakal` float NULL DEFAULT NULL,
  `bahre_anten` float NULL DEFAULT NULL COMMENT 'dbi',
  `shomare_seriale_dastgah` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `teke_bande_ferekansi` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL COMMENT 'عدد یا حروف بپرس',
  `hadeaxar_tavane_khoroji_ferestande` float NULL DEFAULT NULL COMMENT 'نوع دیتا رو بپرس',
  `marke_dastgah` int NULL DEFAULT NULL COMMENT 'onvan4',
  `modele_dastgah` int NULL DEFAULT NULL COMMENT 'onvan4',
  `ip_address` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `port` int NULL DEFAULT NULL,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ssid` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `software` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `noe_link` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT NULL,
  `link_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `popsite`(`popsite`) USING BTREE,
  CONSTRAINT `bnm_wireless_ap_ibfk_1` FOREIGN KEY (`popsite`) REFERENCES `bnm_popsite` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_wireless_station
-- ----------------------------
DROP TABLE IF EXISTS `bnm_wireless_station`;
CREATE TABLE `bnm_wireless_station`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tarikhe_payan` date NULL DEFAULT NULL,
  `tarikhe_sabt` date NULL DEFAULT NULL,
  `shomare_link_sabt_samane` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `popsite` int NULL DEFAULT NULL COMMENT 'tarif1',
  `shenase_dakal` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ostan` int NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `tol_joghrafiai` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `arz_joghrafiai` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ertefae_sakhteman` float NULL DEFAULT NULL,
  `ertefae_dakal` float NULL DEFAULT NULL,
  `bahre_anten` float NULL DEFAULT NULL COMMENT 'dbi',
  `shomare_seriale_dastgah` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `hadeaxar_tavane_khoroji_ferestande` float NULL DEFAULT NULL COMMENT 'نوع دیتا رو بپرس',
  `marke_dastgah` int NULL DEFAULT NULL COMMENT 'onvan4',
  `modele_dastgah` int NULL DEFAULT NULL COMMENT 'onvan4',
  `ip_address` varchar(15) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `port` int NULL DEFAULT NULL,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT '',
  `software` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `istgahe_dovom` varchar(80) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `subscriber_id` int NULL DEFAULT NULL,
  `telephone` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `wireless_ap` int NULL DEFAULT NULL,
  `branch_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for bnm_zarinpal
-- ----------------------------
DROP TABLE IF EXISTS `bnm_zarinpal`;
CREATE TABLE `bnm_zarinpal`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `merchantcode` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `userid` int NULL DEFAULT NULL,
  `branchid` int NULL DEFAULT NULL,
  `usertype` int NULL DEFAULT NULL,
  `amount` float NULL DEFAULT NULL,
  `tstarikh` timestamp NULL DEFAULT current_timestamp,
  `tarikh` datetime NULL DEFAULT NULL,
  `authority` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `callback_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NULL DEFAULT NULL,
  `remote_addr_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code` int NULL DEFAULT NULL COMMENT 'ghabl az erjae karbar be safhe pardakht',
  `status` varchar(3) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ref_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `verifycode` int NULL DEFAULT NULL,
  `card_pan` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `card_hash` varchar(128) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `fee_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `fee` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 86 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eusers
-- ----------------------------
DROP TABLE IF EXISTS `eusers`;
CREATE TABLE `eusers`  (
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lname` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birth` date NOT NULL,
  `mary` date NOT NULL,
  `gender` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fax` int NOT NULL DEFAULT 0,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `emailc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `coname` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comobile` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cotel` int NOT NULL DEFAULT 0,
  `cofax` int NOT NULL DEFAULT 0,
  `mname` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `website` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `coemail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ordname` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `coemailc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `coaddress` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `stype` tinyint NOT NULL DEFAULT 0,
  `nhours` int NOT NULL DEFAULT 0,
  `price` int NOT NULL DEFAULT 0,
  `dhours` int NOT NULL DEFAULT 0,
  `username` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pass` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pin` int NOT NULL DEFAULT 0,
  `operator` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `visitor` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `regdate` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `ncode` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `job` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tahsilat` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rabetname` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sematerabet` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `resellerid` int NOT NULL,
  `flink1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `flink2` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `flink3` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `flink4` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `flink5` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `flink6` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lfact` int NOT NULL,
  `status` tinyint NOT NULL,
  `lfact0` int NOT NULL,
  `lfact1` int NOT NULL,
  `lfact2` int NOT NULL,
  `lfact3` int NOT NULL,
  `lfact4` int NOT NULL,
  `lfact5` int NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `supply` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ename` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elname` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fathername` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `msodur` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ss` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `lang` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `erabetname` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `field` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cotype` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `regno` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `msabt` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `stock_box` int NOT NULL,
  `noe_moshtarak` int NOT NULL,
  UNIQUE INDEX `id`(`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 68103 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for old_voip
-- ----------------------------
DROP TABLE IF EXISTS `old_voip`;
CREATE TABLE `old_voip`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ss` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `miladi` date NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `ostan` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1746 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for old_voip-old
-- ----------------------------
DROP TABLE IF EXISTS `old_voip-old`;
CREATE TABLE `old_voip-old`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ss` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1512 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for old_voip_beforedelete
-- ----------------------------
DROP TABLE IF EXISTS `old_voip_beforedelete`;
CREATE TABLE `old_voip_beforedelete`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ss` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `miladi` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1746 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for old_voip_ostan_update
-- ----------------------------
DROP TABLE IF EXISTS `old_voip_ostan_update`;
CREATE TABLE `old_voip_ostan_update`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ss` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `miladi` date NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `ostan` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1746 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for shahkar_log
-- ----------------------------
DROP TABLE IF EXISTS `shahkar_log`;
CREATE TABLE `shahkar_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `factor_id` int NULL DEFAULT NULL,
  `noe_darkhast` int NOT NULL COMMENT '1=service_request, 2=estelam request',
  `subscriber_id` int NULL DEFAULT NULL,
  `emkanat_id` int NULL DEFAULT NULL,
  `service_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `request_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `creator` int NULL DEFAULT NULL,
  `date` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `datem` timestamp(6) NULL DEFAULT NULL,
  `response` int NULL DEFAULT NULL,
  `requestname` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `comment` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikh` datetime(6) NULL DEFAULT NULL,
  `shahkarid` varchar(45) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `classifier` varchar(128) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `result` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `responseid` varchar(128) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `jresponse` longtext CHARACTER SET utf8 COLLATE utf8_persian_ci NULL,
  `requestid` varbinary(60) NULL DEFAULT NULL,
  `telephone` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5003 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for siam_staff
-- ----------------------------
DROP TABLE IF EXISTS `siam_staff`;
CREATE TABLE `siam_staff`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `pass` varchar(64) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `status` int UNSIGNED NULL DEFAULT 1 COMMENT '1=Enable,2=Disable',
  `counter` int NULL DEFAULT NULL COMMENT 'agar counter 3 shod status =1 shavad',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf32 COLLATE utf32_persian_ci NULL DEFAULT NULL,
  `date` timestamp(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf32 COLLATE = utf32_persian_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for test2
-- ----------------------------
DROP TABLE IF EXISTS `test2`;
CREATE TABLE `test2`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `t1` bigint NULL DEFAULT NULL,
  `t2` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 141 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_voip_shahkar
-- ----------------------------
DROP TABLE IF EXISTS `user_voip_shahkar`;
CREATE TABLE `user_voip_shahkar`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `subid` int NULL DEFAULT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `telephone_hamrah` varchar(12) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `classifier` varchar(120) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `response` int NULL DEFAULT NULL,
  `comment` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `providerName` varchar(120) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `result` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `req` int NULL DEFAULT 0,
  `requestId` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 317 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usertel
-- ----------------------------
DROP TABLE IF EXISTS `usertel`;
CREATE TABLE `usertel`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 107 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for voipfactors
-- ----------------------------
DROP TABLE IF EXISTS `voipfactors`;
CREATE TABLE `voipfactors`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikh` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `gheymat` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `servicename` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `serid` int NULL DEFAULT NULL,
  `tarikhe_factor` date NULL DEFAULT NULL,
  `tarikhe_payan` date NULL DEFAULT NULL,
  `subid` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3095 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wafac
-- ----------------------------
DROP TABLE IF EXISTS `wafac`;
CREATE TABLE `wafac`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tarikh` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `gheymat` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `servicename` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `serid` int NULL DEFAULT NULL,
  `tarikhe_factor` date NULL DEFAULT NULL,
  `tarikhe_payan` date NULL DEFAULT NULL,
  `subid` int NULL DEFAULT NULL,
  `miladi` date NULL DEFAULT NULL,
  `gheymateservice` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mobile` varchar(15) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tel2` varchar(30) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5305 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wafactors
-- ----------------------------
DROP TABLE IF EXISTS `wafactors`;
CREATE TABLE `wafactors`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `f_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `code_meli` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `name_pedar` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `ss` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `mt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `tt` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `miladi` date NULL DEFAULT NULL,
  `shahr` int NULL DEFAULT NULL,
  `ostan` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4206 CHARACTER SET = utf8 COLLATE = utf8_persian_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
