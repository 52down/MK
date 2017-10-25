

INSERT INTO xcart_config SET name='amazon_pa_sid', comment='Amazon Seller ID', value='', category='Amazon_Payments_Advanced', orderby='10', type='text', defvalue='', variants='', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_access_key', comment='Access Key ID', value='', category='Amazon_Payments_Advanced', orderby='12', type='trimmed_text', defvalue='', variants='', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_cid', comment='Client ID', value='', category='Amazon_Payments_Advanced', orderby='14', type='trimmed_text', defvalue='', variants='', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_mode', comment='Operation mode', value='test', category='Amazon_Payments_Advanced', orderby='5', type='selector', defvalue='live', variants='live:lbl_live\ntest:lbl_test', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_secret_key', comment='Secret Access Key', value='', category='Amazon_Payments_Advanced', orderby='13', type='trimmed_text', defvalue='', variants='', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_region', comment='Region', value='us', category='Amazon_Payments_Advanced', orderby='50', type='selector', defvalue='us', variants='us:United States\nuk:United Kingdom\nde:Germany\njp:Japan', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_currency', comment='Currency', value='USD', category='Amazon_Payments_Advanced', orderby='55', type='selector', defvalue='USD', variants='USD:U.S. Dollars (USD)\nGBP:British Pounds (GBP)\nEUR:European Currency Unit (EUR)\nJPY:Japanese Yen (JPY)', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_capture_mode', comment='Capture mode', value='C', category='Amazon_Payments_Advanced', orderby='60', type='selector', defvalue='C', variants='A:lbl_amazon_pa_auth_then_capture\nC:lbl_amazon_pa_capture_now', validation='', signature='';
INSERT INTO xcart_config SET name='amazon_pa_sync_mode', comment='Type of authorization request', value='S', category='Amazon_Payments_Advanced', orderby='65', type='selector', defvalue='S', variants='S:lbl_amazon_pa_synchronous\nA:lbl_amazon_pa_asynchronous', validation='', signature='';

INSERT INTO xcart_modules SET module_name='Amazon_Payments_Advanced', module_descr='This modules enables advanced Amazon payments', active='N', init_orderby='0', author='qualiteam', module_url='', tags='checkout';

