CREATE TABLE xcart_facebook_ecomm_feed_files (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  filename varchar(255) NOT NULL DEFAULT '',
  hash_key char(50) NOT NULL DEFAULT '' COMMENT 'generated in changeFileStatistic()->func_get_secure_random_key(50,..',
  update_date int(11) NOT NULL DEFAULT '0',
  fetch_date int(11) NOT NULL DEFAULT '0',
  language_code char(2) NOT NULL DEFAULT '' COMMENT 'xcart_languages.code',
  currency_code char(3) NOT NULL DEFAULT '' COMMENT 'xcart_mc_currencies.code or ISO',
  age_group enum('newborn','infant','toddler','kids','adult') DEFAULT 'adult' COMMENT 'https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/v2.9#feed-format',
  rows_count mediumint(11) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  UNIQUE changeFileStatistic(filename),
  KEY facebook_ecomm_get_file_feed(hash_key),
  KEY FeedsFeDisplay(update_date)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE xcart_facebook_ecomm_pending_export (
  productid int(11) NOT NULL COMMENT 'xcart_products.productid',
  sessid binary(32) NOT NULL COMMENT 'Use func_binary_empty',
  UNIQUE markProductsPending (sessid,productid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE xcart_facebook_ecomm_marked_products (
  productid int(11) NOT NULL COMMENT 'xcart_products.productid',
  PRIMARY KEY (productid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



INSERT INTO xcart_config SET name='facebook_ecomm_general_settings', comment='General settings', value='', category='Facebook_Ecommerce', orderby='10', type='separator', defvalue='', variants='', validation='' ON DUPLICATE KEY UPDATE orderby=orderby;
INSERT INTO xcart_config SET name='facebook_ecomm_pixel_id', comment='Facebook Pixel ID', value='', category='Facebook_Ecommerce', orderby='20', type='trimmed_text', defvalue='', variants='', validation='' ON DUPLICATE KEY UPDATE orderby=orderby;
INSERT INTO xcart_config SET name='facebook_ecomm_weight_unit', comment='Weight symbol', value='lb', category='Facebook_Ecommerce', orderby='30', type='selector', defvalue='lb', variants='lb:lb\noz:oz\ng:g\nkg:kg', validation='' ON DUPLICATE KEY UPDATE orderby=orderby;
INSERT INTO xcart_config SET name='facebook_ecomm_frequency_feed', comment='Frequency of product feeds renewal', value='daily', category='Facebook_Ecommerce', orderby='40', type='selector', defvalue='daily', variants='hourly:lbl_facebook_ecomm_hourly\ndaily:lbl_facebook_ecomm_daily\nweekly:lbl_facebook_ecomm_weekly', validation='' ON DUPLICATE KEY UPDATE orderby=orderby;

INSERT INTO xcart_modules SET module_name='Facebook_Ecommerce', module_descr='This add-on syncs your X-Cart and your Facebook catalogs to help you make maximum use of Facebook Marketing tools having your products promoted to the right audience in the right place at the right time.', active='N', init_orderby=0, author='qualiteam', tags='marketing' ON DUPLICATE KEY UPDATE module_descr=module_descr;
