CREATE TABLE IF NOT EXISTS `xcart_mailchimp_newslists` (
	listid int(11) NOT NULL auto_increment,
	name varchar(255) NOT NULL default '',
	descr text NOT NULL,
	show_as_news char(1) NOT NULL default 'N',
	avail char(1) NOT NULL default 'N',
	subscribe char(1) NOT NULL default 'N',
	lngcode char(2) NOT NULL default 'en',
	mc_list_id varchar(25) default '',
	PRIMARY KEY (listid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `xcart_mailchimp_campaigns_stores` (
	internal_store_id int(11) unsigned NOT NULL AUTO_INCREMENT,
	campaign_code varchar(255) NOT NULL default '',
	store_code varchar(50) NOT NULL default '' COMMENT 'Limit in addStore, XCMailChimpEcomm::ID_LIMIT_LENGTH',
	`expire` int(11) unsigned NOT NULL DEFAULT '0',
	KEY del_in_getStoreIdByCampaignId (`expire`),
	UNIQUE KEY (campaign_code),
	PRIMARY KEY (internal_store_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `xcart_mailchimp_default_stores` (
	store_code varchar(50) NOT NULL default '' COMMENT 'Limit in addStore, XCMailChimpEcomm::ID_LIMIT_LENGTH',
	list_code varchar(255) NOT NULL default '',
	name varchar(255) NOT NULL default '',
	KEY (list_code(20))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xcart_mailchimp_product_batches` (
	productid int(11) NOT NULL COMMENT 'xcart_products.productid',
	product_variant_id varchar(32) NOT NULL default '' COMMENT 'from getProductVariantId, productid or xcart_variants.productcode varchar(32)',
	batch text NOT NULL,
	`expire` int(11) unsigned NOT NULL DEFAULT '0',
	KEY del_in_sendCartProducts (`expire`),
	PRIMARY KEY (productid,product_variant_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xcart_mailchimp_products` (
	store_code varchar(50) NOT NULL DEFAULT '' COMMENT 'Foreign key for xcart_mailchimp_campaigns_stores.store_code',
	productid int(11) NOT NULL COMMENT 'xcart_products.productid',
	product_variant_id varchar(32) NOT NULL default '' COMMENT 'from getProductVariantId, productid or xcart_variants.productcode varchar(32)',
	`expire` int(11) unsigned NOT NULL DEFAULT '0',
	KEY del_in_sendCartProducts (`expire`),
	PRIMARY KEY (productid,store_code,product_variant_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xcart_mailchimp_abandoned_carts` (
	sessid binary(32) NOT NULL COMMENT 'Use func_binary_empty',
	cartid binary(32) NOT NULL COMMENT 'Use func_binary_empty',
	saved_cart mediumblob NOT NULL COMMENT 'binary-safe blob is used to avoid data corruption with php unserialize function, can be userid',
	expiry int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Changed in func_save_customer_cart,Used in func_restore_serialized_cart',
	PRIMARY KEY (sessid),
	KEY deleteObsolete1 (`expiry`),
	KEY restoreNredirect (`cartid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO xcart_modules SET module_name='Adv_Mailchimp_Subscription', module_descr='This module allows to use advanced MailChimp newsletters management service. To create a MailChimp account please <a href="http://www.mailchimp.com/signup/?pid=xcart&amp;source=website" target="_blank">click here</a>.', active='N', init_orderby=0, author='qualiteam', tags='marketing' ON DUPLICATE KEY UPDATE module_descr='This module allows to use advanced MailChimp newsletters management service. To create a MailChimp account please <a href="http://www.mailchimp.com/signup/?pid=xcart&amp;source=website" target="_blank">click here</a>.';



REPLACE INTO xcart_config SET name='adv_mailchimp_general_settings', comment='General settings', value='', category='Adv_Mailchimp_Subscription', orderby='10', type='separator', defvalue='', variants='', validation='';
INSERT INTO xcart_config SET name='adv_mailchimp_apikey', comment='API Key : You can grab your API Key from here: http://admin.mailchimp.com/account/api-key-popup', value='', category='Adv_Mailchimp_Subscription', orderby='20', type='trimmed_text', defvalue='', variants='', validation='' ON DUPLICATE KEY UPDATE orderby='20';

REPLACE INTO xcart_config SET name='adv_mailchimp_register_opt', comment='Enable confirmation request for subscription from users profile page', value='Y', category='Adv_Mailchimp_Subscription', orderby='30', type='checkbox', defvalue='Y', variants='', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_ecommerce_settings', comment='E-Commerce settings', value='', category='Adv_Mailchimp_Subscription', orderby='40', type='separator', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_send_orders', comment='Send Orders', value='N', category='Adv_Mailchimp_Subscription', orderby='50', type='checkbox', defvalue='N', variants='', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_send_carts', comment='Send Carts', value='N', category='Adv_Mailchimp_Subscription', orderby='60', type='checkbox', defvalue='N', variants='', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_p_recommendations', comment='Enable Product Recommendations', value='N', category='Adv_Mailchimp_Subscription', orderby='70', type='checkbox', defvalue='N', variants='', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_subscribe_order', comment='Automatically subscribe email addresses associated with carts/orders created during a campaign', value='N', category='Adv_Mailchimp_Subscription', orderby='80', type='checkbox', defvalue='N', variants='', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_currency_code', comment='Currency', value='USD', category='Adv_Mailchimp_Subscription', orderby='90', type='selector', defvalue='USD', variants='func_mailchimp_adm_get_currencies', validation='';
REPLACE INTO xcart_config SET name='adv_mailchimp_campaign_expire', comment='Time period during which new orders should be associated with a campaign (in days)', value='15', category='Adv_Mailchimp_Subscription', orderby='100', type='text', defvalue='15', variants='', validation='udouble';
REPLACE INTO xcart_config SET name='adv_mailchimp_default_store', comment='Link orders created outside campaigns to this store', value='', category='Adv_Mailchimp_Subscription', orderby='110', type='selector', defvalue='', variants='func_mailchimp_adm_get_stores', validation='';

