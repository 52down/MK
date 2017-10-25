CREATE TABLE xcart_xauth_user_ids (
	auth_id int(11) NOT NULL auto_increment PRIMARY KEY,
	id int(11) NOT NULL default 0,
	service varchar(32) NOT NULL default '',
	provider varchar(32) NOT NULL default '',
	identifier varchar(255) NOT NULL default '',
	signature char(40) NOT NULL DEFAULT '' COMMENT 'Used to validate auth_id,id,service,provider,identifier fields',
	UNIQUE KEY isp (identifier, service, provider),
	KEY sp (service, provider),
	KEY id (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

REPLACE INTO xcart_modules (module_name, module_descr, active, init_orderby, author, module_url, tags) VALUES ('XAuth', '', 'N',0,'qualiteam','','userexp');

REPLACE INTO xcart_config SET name='xauth_create_profile', comment='Create profile', value='Y', category='XAuth', orderby='10', type='checkbox', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_auto_login', comment='Auto login', value='Y', category='XAuth', orderby='20', type='checkbox', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_login_by_email', comment='Login by email', value='Y', category='XAuth', orderby='30', type='checkbox', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_sep1', comment='Social Login options', value='', category='XAuth', orderby='40', type='separator', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_rpx_api_key', comment='API key (Secret)', value='', category='XAuth', orderby='50', type='text', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_rpx_app_id', comment='Application ID', value='', category='XAuth', orderby='60', type='text', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_rpx_app_domain', comment='Application Domain', value='', category='XAuth', orderby='70', type='trimmed_text', defvalue='', variants='', validation='url';
REPLACE INTO xcart_config SET name='xauth_rpx_display_mode', comment='Display mode', value='h', category='XAuth', orderby='80', type='selector', defvalue='', variants='v:lbl_xauth_display_vertical\nh:lbl_xauth_display_horizontal', validation='';
REPLACE INTO xcart_config SET name='xauth_display_sign_in_link', comment='Display "Sign in" link above the registration form', value='Y', category='XAuth', orderby='90', type='checkbox', defvalue='Y', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_social_sharing_sep', comment='Social Sharing options', value='', category='XAuth', orderby='200', type='separator', defvalue='', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_ss_api_version', comment='Social Sharing API version', value='3', category='XAuth', orderby='210', type='selector', defvalue='3', variants='2:v2\n3:v3', validation='';
REPLACE INTO xcart_config SET name='xauth_ss_providers', comment='Social Sharing providers', value='native-facebook;native-googleplus;native-linkedin;native-twitter', category='XAuth', orderby='220', type='multiselector', defvalue='native-facebook;native-googleplus;native-linkedin;native-twitter', variants='facebook:lbl_xauth_facebook\nlinkedin:lbl_xauth_linkedin\nmixi:lbl_xauth_mixi\nqq:lbl_xauth_qq\ntencentweibo:lbl_xauth_tencentweibo\ntwitter:lbl_xauth_twitter\nxing:lbl_xauth_xing\nnative-facebook:lbl_xauth_facebook_native\nnative-googleplus:lbl_xauth_googleplus_native\nnative-linkedin:lbl_xauth_linkedin_native\nnative-mixi:lbl_xauth_mixi_native\nnative-odnoklassniki:lbl_xauth_odnoklassniki_native\nnative-pinterest:lbl_xauth_pinterest_native\nnative-reddit:lbl_xauth_reddit_native\nnative-sinaweibo:lbl_xauth_sinaweibo_native\nnative-tumblr:lbl_xauth_tumblr_native\nnative-twitter:lbl_xauth_twitter_native\nnative-vk:lbl_xauth_vk_native\nnative-xing:lbl_xauth_xing_native\nemail-google:lbl_xauth_google_email\nemail-mailto:lbl_xauth_mailto_email\nemail-yahoo:lbl_xauth_yahoo_email', validation='';
REPLACE INTO xcart_config SET name='xauth_enable_social_sharing', comment='Enable Social Sharing on Product page', value='N', category='XAuth', orderby='230', type='checkbox', defvalue='N', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_enable_ss_cart', comment='Enable Social Sharing on Cart page', value='N', category='XAuth', orderby='240', type='checkbox', defvalue='N', variants='', validation='';
REPLACE INTO xcart_config SET name='xauth_enable_ss_invoice', comment='Enable Social Sharing on Invoice page', value='N', category='XAuth', orderby='250', type='checkbox', defvalue='N', variants='', validation='';
