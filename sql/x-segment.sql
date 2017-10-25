INSERT INTO xcart_modules SET module_name='Segment', module_descr='Segment is a powerful data aggregator, it tracks e-commerce events and sends this info to such apps as Mixpanel, Google Analytics, Localytics, RJ Metrics, SalesForce, HubSpot, Optimizely, Clicky and other data processing tools.', active='N', author='qualiteam', tags='marketing,stats';


INSERT INTO xcart_config SET name='segment_sep_connection', comment='Connection settings', value='', category='Segment', orderby='10', type='separator', defvalue='', variants='';


INSERT INTO xcart_config SET name='segment_write_key', comment='Write key (You can find it in your project setup guide or settings)', value='', category='Segment', orderby='20', type='trimmed_text', defvalue='', variants='';


INSERT INTO xcart_config SET name='segment_sep_user_events', comment='User events', value='', category='Segment', orderby='40', type='separator', defvalue='', variants='';
INSERT INTO xcart_config SET name='segment_t_open_login_popup', comment='Track the event \"Open Login Popup\"', value='Y', category='Segment', orderby='50', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_logged_in', comment='Track the event \"Logged In\"', value='Y', category='Segment', orderby='60', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_logged_off', comment='Track the event \"Logged Off\"', value='Y', category='Segment', orderby='70', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_sent_contact_us', comment='Track the event \"Sent Contact Us\"', value='Y', category='Segment', orderby='80', type='checkbox', defvalue='Y', variants='';

INSERT INTO xcart_config SET name='segment_sep_catalog_events', comment='Catalog events', value='', category='Segment', orderby='90', type='separator', defvalue='', variants='';
INSERT INTO xcart_config SET name='segment_t_viewed_category', comment='Track the event \"Viewed Product Category\"', value='Y', category='Segment', orderby='100', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_viewed_product', comment='Track the event \"Viewed Product\"', value='Y', category='Segment', orderby='110', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_search_products', comment='Track the event \"Search Products\"', value='Y', category='Segment', orderby='120', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_send2friend', comment='Track the event \"Send to Friend\"', value='Y', category='Segment', orderby='130', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_sent_survey', comment='Track the event \"Sent Survey\"', value='Y', category='Segment', orderby='140', type='checkbox', defvalue='Y', variants='';

INSERT INTO xcart_config SET name='segment_sep_produc_events', comment='Product events', value='', category='Segment', orderby='150', type='separator', defvalue='', variants='';
INSERT INTO xcart_config SET name='segment_t_product_xmagnifier', comment='Track the event \"Magnifier More views jump\"', value='Y', category='Segment', orderby='160', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_product_special_offers', comment='Track the event \"Special offers jump\"', value='Y', category='Segment', orderby='170', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_product_send2friend', comment='Track the event \"Send to friend jump\"', value='Y', category='Segment', orderby='180', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_product_dpimages', comment='Track the event \"Detailed images jump\"', value='Y', category='Segment', orderby='190', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_product_relateds', comment='Track the event \"Related products jump\"', value='Y', category='Segment', orderby='200', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_product_recommends', comment='Track the event \"Customers also bought jump\"', value='Y', category='Segment', orderby='210', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_product_feedback', comment='Track the event \"Customer feedback jump\"', value='Y', category='Segment', orderby='220', type='checkbox', defvalue='Y', variants='';


INSERT INTO xcart_config SET name='segment_sep_cart_events', comment='Cart events', value='', category='Segment', orderby='230', type='separator', defvalue='', variants='';
INSERT INTO xcart_config SET name='segment_t_added_product', comment='Track the event \"Added Product\"', value='Y', category='Segment', orderby='240', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_removed_product', comment='Track the event \"Removed Product\"', value='Y', category='Segment', orderby='250', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_updated_product', comment='Track the event \"Updated Product Quantity\"', value='Y', category='Segment', orderby='260', type='checkbox', defvalue='Y', variants='';
INSERT INTO xcart_config SET name='segment_t_open_minicart', comment='Track the event \"Open Minicart\"', value='Y', category='Segment', orderby='270', type='checkbox', defvalue='Y', variants='';


INSERT INTO xcart_config SET name='segment_sep_order_events', comment='Order events', value='', category='Segment', orderby='280', type='separator', defvalue='', variants='';
INSERT INTO xcart_config SET name='segment_t_completed_order', comment='Track the event \"Completed Order\"', value='Y', category='Segment', orderby='290', type='checkbox', defvalue='Y', variants='';
