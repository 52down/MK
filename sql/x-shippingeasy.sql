CREATE TABLE `xcart_shippingeasy_order_status` (
    `orderid` int(11) NOT NULL,
    `status` char(1) NOT NULL default '',
    PRIMARY KEY (orderid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `xcart_shippingeasy_shipped_order_items` (
    `itemid` int(11) NOT NULL,
    PRIMARY KEY (itemid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `xcart_shippingeasy_statuses` (
    `id` smallint(11) unsigned NOT NULL auto_increment,
    `x_status` char(1) NOT NULL default '',
    `se_status` varchar(32) NOT NULL default '',
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `xcart_config` SET name='shippingeasy_api_key', comment='API Key', value='', category='ShippingEasy', orderby='10', type='text', defvalue='', variants='', validation='', signature='';
INSERT INTO `xcart_config` SET name='shippingeasy_api_secret', comment='API Secret', value='', category='ShippingEasy', orderby='20', type='text', defvalue='', variants='', validation='', signature='';
INSERT INTO `xcart_config` SET name='shippingeasy_staging_account', comment='Staging account', value='N', category='ShippingEasy', orderby='50', type='checkbox', defvalue='N', variants='', validation='', signature='';
INSERT INTO `xcart_config` SET name='shippingeasy_store_api_key', comment='Store API Key', value='', category='ShippingEasy', orderby='30', type='text', defvalue='', variants='', validation='', signature='';
INSERT INTO `xcart_modules` SET module_name='ShippingEasy', module_descr='Save time and money with the shipping solution built for eCommerce retailers! ShippingEasy downloads orders in real-time and automates your shipping based on carrier, service, package and more.', active='N', tags='shipping', author='qualiteam';
