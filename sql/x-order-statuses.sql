



CREATE TABLE `xcart_custom_order_statuses` (
  `statusid` int(11) NOT NULL auto_increment,
  `code` char(2) NOT NULL DEFAULT '' COMMENT 'XC_XOSTAT_STATUS_LENGTH from config.php. The type must be the same as xcart_orders.status',
  `color` char(6) NOT NULL DEFAULT '',
  `inactive_color` char(6) NOT NULL DEFAULT '',
  `show_in_progress` char(1) NOT NULL DEFAULT 'Y',
  `only_when_active` char(1) NOT NULL DEFAULT 'N',
  `reserve_products` char(1) NOT NULL DEFAULT 'Y',
  `notify_customer` char(1) NOT NULL DEFAULT 'Y',
  `notify_orders_dep` char(1) NOT NULL DEFAULT 'Y',
  `notify_provider` char(1) NOT NULL DEFAULT 'Y',
  `orderby` mediumint(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`statusid`),
  UNIQUE KEY (`code`),
  UNIQUE KEY os(`orderby`, `statusid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='covering os key is used in func_orderstatuses_get_status_list_by_id';

REPLACE INTO `xcart_modules` (`module_name`, `module_descr`, `author`, `tags`) VALUES ('XOrder_Statuses', 'Allows to manage the order statuses, used in the store.', 'qualiteam', 'orders');

REPLACE INTO `xcart_config` (`category`, `name`, `value`, `comment`, `type`, `defvalue`, `variants`) VALUES ('XOrder_Statuses', 'xostat_use_colors', 'Y', 'Use colors for order statuses', 'checkbox', '', '');
REPLACE INTO `xcart_config` (`category`, `name`, `value`, `comment`, `type`, `defvalue`, `variants`) VALUES ('XOrder_Statuses', 'xostat_send_email_to_provider', 'Y', 'Send a notification to the product owner when the order status is changed to a custom one', 'checkbox', 'Y', '');




REPLACE INTO `xcart_custom_order_statuses` VALUES (1, 'I', 'FF7CD8', 'c6c6c6', 'N', 'N', 'Y', 'N', 'N', 'N', 10);
REPLACE INTO `xcart_custom_order_statuses` VALUES (2, 'Q', 'B6E026', '949494', 'Y', 'N', 'Y', 'N', 'N', 'N', 20);
REPLACE INTO `xcart_custom_order_statuses` VALUES (3, 'A', 'F1DA36', 'ababab', 'N', 'N', 'Y', 'N', 'N', 'N', 30);
REPLACE INTO `xcart_custom_order_statuses` VALUES (4, 'P', '61C419', '6a6a6a', 'Y', 'N', 'Y', 'N', 'N', 'N', 40);
REPLACE INTO `xcart_custom_order_statuses` VALUES (5, 'D', 'FF670F', '7c7c7c', 'N', 'N', 'N', 'N', 'N', 'N', 50);
REPLACE INTO `xcart_custom_order_statuses` VALUES (6, 'F', 'FF1A00', '5e5e5e', 'N', 'N', 'N', 'N', 'N', 'N', 60);
REPLACE INTO `xcart_custom_order_statuses` VALUES (7, 'C', '006E2E', '343434', 'Y', 'N', 'Y', 'N', 'N', 'N', 70);
REPLACE INTO `xcart_custom_order_statuses` VALUES (8, 'B', 'C79810', '7a7a7a', 'N', 'N', 'Y', 'N', 'N', 'N', 80);
REPLACE INTO `xcart_custom_order_statuses` VALUES (9, 'R', 'F0610E', '636363', 'N', 'N', 'N', 'N', 'N', 'N', 90);
