



CREATE TABLE IF NOT EXISTS `xcart_mc_currencies` (
  `code` char(3) NOT NULL default '',
  `symbol` varchar(128) NOT NULL default '',
  `rate` decimal(12,4) NOT NULL default 1 COMMENT 'Use func_decimal_empty',
  `is_default` int(1) NOT NULL default 0,
  `format` varchar(16) NOT NULL default '',
  `number_format` varchar(3) NOT NULL default '',
  `enabled` int(1) NOT NULL default 1,
  `is_default_in_frontend` int(1) NOT NULL default 0,
  `pos` int(11) NOT NULL default 0,
  PRIMARY KEY  (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xcart_mc_geolite_networks` (
  `address` varchar(44) NOT NULL default '',
  `geoname_id` int NOT NULL DEFAULT 0,
  `low_subnet` bigint(20) UNSIGNED NOT NULL default 0,
  `low_interface` bigint(20) UNSIGNED NOT NULL default 0,
  `high_subnet` bigint(20) UNSIGNED NOT NULL default 0,
  `high_interface` bigint(20) UNSIGNED NOT NULL default 0,
  INDEX `geoname_id` (`geoname_id`),
  INDEX `ip_search` (`low_subnet`, `low_interface`, `high_subnet`, `high_interface`),
  PRIMARY KEY (`address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xcart_mc_geolite_locations` (
  `geoname_id` int NOT NULL DEFAULT 0,
  `country_code` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`geoname_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

REPLACE INTO `xcart_mc_currencies` SET `code`='USD', `is_default`=1, `format`='$x', `number_format`='2.';

REPLACE INTO `xcart_modules` SET `module_name`='XMultiCurrency', `module_descr`='This module adds multicurrency feature for your store.', `active`='N', `init_orderby`='0', `author`='qualiteam', `module_url`='', `tags`='userexp';

REPLACE INTO `xcart_config` SET `name`='mc_autoupdate_enabled', `comment`='', `value`='N', `category`='', `orderby`='10', `type`='checkbox', `defvalue`='N', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_allow_select_country', `comment`='', `value`='Y', `category`='', `orderby`='10', `type`='checkbox', `defvalue`='N', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_autoupdate_time', `comment`='', `value`='13:30', `category`='', `orderby`='10', `type`='text', `defvalue`='', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_online_service', `comment`='', `value`='gfin', `category`='', `orderby`='10', `type`='text', `defvalue`='', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_use_custom_countries_list', `comment`='', `value`='N', `category`='', `orderby`='10', `type`='checkbox', `defvalue`='N', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_excluded_countries_list', `comment`='', `value`='', `category`='', `orderby`='10', `type`='text', `defvalue`='', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_geoip_service', `comment`='', `value`='freegeoip', `category`='', `orderby`='10', `type`='text', `defvalue`='freegeoip', `variants`='';
REPLACE INTO `xcart_config` SET `name`='mc_autoupdate_time', `comment`='', `value`='0', `category`='', `orderby`='10', `type`='text', `defvalue`='', `variants`='';
