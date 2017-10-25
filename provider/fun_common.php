<?php
function save_image($file_path,$productid,$file_name,$type="T"){
	global $sql_tbl;
//imageid 	id 	image 	image_path 	image_type 	image_x 	image_y 	image_size 	filename 	date 	alt 	avail 	orderby 	md5
	$image = file_get_contents($file_path);
	$size = getimagesize($file_path);
	$imgName = strrchr($file_path,"/");
	$imgName = str_replace("/","",$imgName);
	preg_match("/^(.+)\.([^\.]+)$/Ss", $imgName, $match);
	$file_ext = $match[2];
	$is_unique = func_image_filename_is_unique($file_name . '.' . $file_ext, $type, $imageid);
	if(!$is_unique){
	do {
        $file__name = sprintf("%s-%02d", $file_name, $idx++);
        $is_unique = func_image_filename_is_unique($file__name . '.' . $file_ext, $type, $imageid);
    } while (!$is_unique);
	$filename = $file__name . '.' . $file_ext;
	}
	else
	$filename = $file_name . '.' . $file_ext;
	
	$image_data = array(
		"image_size" => strlen($image),
		"md5" => md5($image),
		"filename" => $filename,
		"image_type" => $size["mime"],
		"image_x" => $size[0],
		"image_y" => $size[1],
		"image_path" => "./images/$type/$filename"
	);
	
	$image_data['id'] = $productid;
	$image_data['date'] = time();

	$imageid = func_array2insert('images_' . $type, $image_data);
	
	if(!$imageid)
		return false;
	
	if( copy($file_path,"../images/$type/$filename") )
		return $imageid;
	else{
		db_query("DELETE FROM ".$sql_tbl['images_'.$type]." WHERE imageid = '$imageid'");
		return false;
	}
}

function import_product($product_data){
	global $sql_tbl;
	global $config;
	global $massage;
	if(empty($edit_lng)) {
			$edit_lng = $shop_language;
	}
	$provider = 1;
	$forsale = $product_data["forsale"];
	$list_price = $product_data["list_price"];
	$low_avail_limit = 10;
	$min_amount = 1;
	if(!empty($product_data['avail']))
	$avail = $product_data['avail'];
	else $avail = 1000;
	$return_time = 0;
	$free_shipping = "N";
	$shipping_freight = 0;
	$small_item = "Y";
	$length = 0.00;
	if($product_data["total_weight"])
	$weight = $product_data["total_weight"];
	else
	$weight = 0.00;
	$height = 0.00;
	$free_tax = "N";
	$discount_avail = "Y";
	$membershipids[] = -1;
	//$categoryid = $product_data["categoryid"];
	$categoryids = $product_data["categoryids"];
	$categoryid = array_shift($categoryids);
	$price = $product_data["price"];
	$was = $product_data["was"];
	//$prices = $product_data["prices"];
	//$cprices = $product_data["cprices"];
	
	$productcode = $product_data["productcode"];
	$product = addslashes($product_data["product"]);
	$descr = addslashes($product_data["descr"]);
	$fulldescr =  addslashes($product_data["fulldescr"]);
	$ada_compliant = $product_data["ada_compliant"];
	$canopy_height = $product_data["canopy_height"];
	$canopy_width = $product_data["canopy_width"];
	$canopy_length = $product_data["canopy_length"];
	$ballast = addslashes($product_data["ballast"]);
	$blade_material = addslashes($product_data["blade_material"]);
	$blade_pitch = addslashes($product_data["blade_pitch"]);
	$blade_sweep = $product_data["blade_sweep"];
	$fulldescr = addslashes($product_data["fulldescr"]);
	$bulb_included = $product_data["bulb_included"];
	$carton_cube_feet = $product_data["carton_cube_feet"];
	$carton_height = $product_data["carton_height"];
	$carton_length = $product_data["carton_length"];
	$carton_weight = $product_data["carton_weight"];
	$carton_width = $product_data["carton_width"];
	$ceiling_to_blade = $product_data["ceiling_to_blade"];
	$ceiling_to_lowest = $product_data["ceiling_to_lowest"];
	$center_to_bottom = $product_data["center_to_bottom"];
	$center_to_top = $product_data["center_to_top"];
	$chain_length = addslashes($product_data["chain_length"]);
	$clearance = $product_data["clearance"];
	$color_temp = $product_data["color_temp"];
	$control_type = addslashes($product_data["control_type"]);
	$dark_sky = $product_data["dark_sky"];
	$dimmable = $product_data["dimmable"];
	$downrod_1 = addslashes($product_data["downrod_1"]);
	$downrod_1_outside = addslashes($product_data["downrod_1_outside"]);
	$downrod_2 = addslashes($product_data["downrod_2"]);
	$downrod_2_outside = addslashes($product_data["downrod_2_outside"]);
	$energy_star = $product_data["energy_star"];
	$extension = addslashes($product_data["extension"]);
	$family = addslashes($product_data["family"]);
	$finish_descr = addslashes($product_data["finish_descr"]);
	$net_hanging_weight = $product_data["net_hanging_weight"];
	$iheight = addslashes($product_data["iheight"]);
	$height_adjust = $product_data["height_adjust"];
	$high_amps = $product_data["high_amps"];
	$high_cfm = addslashes($product_data["high_cfm"]);
	$high_rpm = $product_data["high_rpm"];
	$high_watts = $product_data["high_watts"];
	$lead_wire = addslashes($product_data["lead_wire"]);
	$ilength = $product_data["ilength"];
	$license_brand = addslashes($product_data["license_brand"]);
	$license_product = $product_data["license_product"];
	$light_kit = $product_data["light_kit"];
	$light_kit_descr = addslashes($product_data["light_kit_descr"]);
	$light_type = addslashes($product_data["light_type"]);
	$low_amps = $product_data["low_amps"];
	$low_cfm = $product_data["low_cfm"];
	$low_rpm = $product_data["low_rpm"];
	$low_watts = $product_data["low_watts"];
	$master_cubic_feet = $product_data["master_cubic_feet"];
	$master_pack = $product_data["master_pack"];
	$master_pack_height = $product_data["master_pack_height"];
	$master_pack_length = $product_data["master_pack_length"];
	$master_pack_weight = $product_data["master_pack_weight"];
	$master_pack_width = $product_data["master_pack_width"];
	$max_bulb_wattage = addslashes($product_data["max_bulb_wattage"]);
	$max_overall_height = $product_data["max_overall_height"];
	$med_amps = $product_data["med_amps"];
	$med_cfm = $product_data["med_cfm"];
	$med_rpm = $product_data["med_rpm"];
	$med_watts = $product_data["med_watts"];
	$min_overall_height = $product_data["min_overall_height"];
	$motor_size = addslashes($product_data["motor_size"]);
	$multi_pack = $product_data["multi_pack"];
	$notes = addslashes($product_data["notes"]);
	$number_of_blade = $product_data["number_of_blade"];
	$number_of_bulb = $product_data["number_of_bulb"];
	$patent = addslashes($product_data["patent"]);
	$photo_cell_included = $product_data["photo_cell_included"];
	$promoted_to_frontpage = $product_data["promoted_to_frontpage"];
	$published = $product_data["published"];
	$room = addslashes($product_data["room"]);
	$saftey_cable_included = $product_data["saftey_cable_included"];
	$shade_finish = addslashes($product_data["shade_finish"]);
	$shade_height = $product_data["shade_height"];
	$shade_length = $product_data["shade_length"];
	$shade_qty = $product_data["shade_qty"];
	$shade_width = $product_data["shade_width"];
	$slope = $product_data["slope"];
	$small_package_shippable = $product_data["small_package_shippable"];
	$socket_type = addslashes($product_data["socket_type"]);
	$title_24 = $product_data["title_24"];
	$title_20 = $product_data["title_20"];
	$uplight = $product_data["uplight"];
	$iwidth = addslashes($product_data["iwidth"]);
	$wire_length = addslashes($product_data["wire_length"]);
	$delivered_lumens = addslashes($product_data["delivered_lumens"]);
	$initial_lumens = addslashes($product_data["initial_lumens"]);
	$featured = $product_data["featured"];
	
  $sku_is_exist = (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[products] WHERE productcode='$productcode' AND productid!='$productid' AND provider = '" . $provider  . "'") ? true : false);
	if (
			!empty($active_modules['Product_Options']) &&
			!$sku_is_exist &&
			func_query_first_cell("SELECT COUNT($sql_tbl[variants].variantid) FROM $sql_tbl[variants], $sql_tbl[products] WHERE $sql_tbl[products].productid = $sql_tbl[variants].productid AND $sql_tbl[variants].productcode = '$productcode' AND $sql_tbl[products].provider = '" . $provider ."'") > 0
	)
			$sku_is_exist = true;
			
	if($sku_is_exist){
		echo "SKU is exist: " . $productcode . "\n";	
		return false;
	}

	// Check if form filled with errors

	$isnt_perms_T = func_check_image_storage_perms($file_upload_data, 'T');
	$isnt_perms_P = func_check_image_storage_perms($file_upload_data, 'P');
	
	$price = abs(doubleval($price));
	$list_price = abs(doubleval($list_price));

	$clean_url = trim(stripslashes($clean_url));

	// Check Clean URL format.
	/*if ($config['SEO']['clean_urls_enabled'] == 'N' || !empty($product_info) && isset($product_info['clean_url']) && !zerolen($product_info['clean_url']) && $product_info['clean_url'] == $clean_url) {
			$clean_url_check_result = true;
	} else {
			list($clean_url_check_result, $check_url_error_code) = func_clean_url_validate($clean_url);
	}*/
	$clean_url_check_result = true;
	$xssfree = true;
	if (!$user_account['allow_active_content']) {
			$res_descr = func_clear_from_xss($descr, false, true);
			$res_fulldescr = func_clear_from_xss($fulldescr, false, true);
			$xssfree_descr = !$res_descr['changed'];
			$xssfree_fulldescr = !$res_fulldescr['changed'];
			$xssfree = $xssfree_descr && $xssfree_fulldescr;
	}
	//$massage .=  $categoryid . " / " . $provider . " / ". $product ." / ". $clean_url_check_result ." / ". $descr ." / ". $avail ." / ". $productcode." / ". $sku_is_exist ." / ". $xssfree ." / ". $esd_err ."\n";	
	$fillerror = (($categoryid == '') ||
			empty($provider) ||
			empty($product) ||
			$clean_url_check_result == false ||
			/*empty($descr) ||
			($avail == '' && !$is_variant && !$is_pconf) ||*/
			($productcode == '') ||
			$sku_is_exist) ||
			!$xssfree ||
			$esd_err ||
			$isnt_perms_T !== true ||
			$isnt_perms_P !== true;
	if (!$fillerror) {

	// If no errors

			if ($xssfree && !$user_account['allow_active_content']) {
					$descr = $res_descr['html'];
					$fulldescr = $res_fulldescr['html'];
			}

			// Create a new product

			// Insert new product into the database and get its productid

			db_query("INSERT INTO $sql_tbl[products] (productcode, provider, add_date) VALUES ('$productcode', '$provider', '".XC_TIME."')");

			$productid = db_insert_id();

			// Insert price and image
			//db_query("INSERT INTO $sql_tbl[pricing] (productid, quantity, price) VALUES ('$productid', '1', '".$price."')");
			if($product_data["image"])
			save_image('../imgtemp/'.$product_data["image"],$productid,str_replace('/','-',$productcode));
			
			if(count($product_data["images"])>0){
				foreach($product_data["images"] as $img_d){
					save_image('../imgtemp/'.$img_d,$productid,str_replace('/','-',$productcode),'D');
				}	
			}

			$save_image_error_T = $save_image_error_P = false;
			
			// Prepare and update categories associated with product...
			$query_data_cat = array(
					'categoryid' => $categoryid,
					'productid'  => $productid,
					'main'       => 'Y'
			);

			if(!func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[products_categories] WHERE categoryid = '$categoryid' AND productid = '$productid' AND main = 'Y'")) {
					db_query("DELETE FROM $sql_tbl[products_categories] WHERE productid = '$productid' AND (main = 'Y' OR categoryid = '$categoryid')");
					func_array2insert('products_categories', $query_data_cat);
			}
			
			if ($categoryids) {
				foreach ($categoryids as $k=>$v) {
					$query_data_cat = array(
							'categoryid' => trim($v),
							'productid'  => $productid,
							'main'       => 'N'
					);
					if (!func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[products_categories] WHERE categoryid = '$v' AND productid = '$productid'")) {
							func_array2insert('products_categories', $query_data_cat);
					}
				}
			}

			$query_data = array(
					'list_price'        => $list_price,
					'productcode'       => $productcode,
					'forsale'           => $forsale,
					'distribution'      => $distribution,
					'free_shipping'     => $free_shipping,
					'shipping_freight'  => $shipping_freight,
					'small_item'        => $small_item,
					'discount_avail'    => $discount_avail,
					'min_amount'        => $min_amount,
					'return_time'       => $return_time,
					'low_avail_limit'   => intval($low_avail_limit),
					'free_tax'          => $free_tax,
					'separate_box'      => $separate_box,
					'meta_keywords'     => $meta_keywords,
					'meta_description'  => $meta_description,
					'title_tag'         => $title_tag,
					
					"ada_compliant" => $ada_compliant,
					"canopy_height" => $canopy_height,
					"canopy_width" => $canopy_width,
					"canopy_length" => $canopy_length,
					"ballast" => $ballast,
					"blade_material" => $blade_material,
					"blade_pitch" => $blade_pitch,
					"blade_sweep" => $blade_sweep,
					"bulb_included" => $bulb_included,
					"carton_cube_feet" => $carton_cube_feet,
					"carton_height" => $carton_height,
					"carton_length" => $carton_length,
					"carton_weight" => $carton_weight,
					"carton_width" => $carton_width,
					"ceiling_to_blade" => $ceiling_to_blade,
					"ceiling_to_lowest" => $ceiling_to_lowest,
					"center_to_bottom" => $center_to_bottom,
					"center_to_top" => $center_to_top,
					"chain_length" => $chain_length,
					"clearance" => $clearance,
					"was" => $was,
					"color_temp" => $color_temp,
					"control_type" => $control_type,
					"dark_sky" => $dark_sky,
					"dimmable" => $dimmable,
					"downrod_1" => $downrod_1,
					"downrod_1_outside" => $downrod_1_outside,
					"downrod_2" => $downrod_2,
					"downrod_2_outside" => $downrod_2_outside,
					"energy_star" => $energy_star,
					"extension" => $extension,
					"family" => $family,
					"finish_descr" => $finish_descr,
					"net_hanging_weight" => $net_hanging_weight,
					"iheight" => $iheight,
					"ilength" => $ilength,
					"iwidth" => $iwidth,
					"height_adjust" => $height_adjust,
					"high_amps" => $high_amps,
					"high_cfm" => $high_cfm,
					"high_rpm" => $high_rpm,
					"high_watts" => $high_watts,
					"lead_wire" => $lead_wire,
					"license_brand" => $license_brand,
					"license_product" => $license_product,
					"light_kit" => $light_kit,
					"light_kit_descr" => $light_kit_descr,
					"light_type" => $light_type,
					"low_amps" => $low_amps,
					"low_cfm" => $low_cfm,
					"low_rpm" => $low_rpm,
					"low_watts" => $low_watts,
					"master_cubic_feet" => $master_cubic_feet,
					"master_pack" => $master_pack,
					"master_pack_height" => $master_pack_height,
					"master_pack_length" => $master_pack_length,
					"master_pack_weight" => $master_pack_weight,
					"master_pack_width" => $master_pack_width,
					"max_bulb_wattage" => $max_bulb_wattage,
					"max_overall_height" => $max_overall_height,
					"med_amps" => $med_amps,
					"med_cfm" => $med_cfm,
					"med_rpm" => $med_rpm,
					"med_watts" => $med_watts,
					"min_overall_height" => $min_overall_height,
					"motor_size" => $motor_size,
					"multi_pack" => $multi_pack,
					"notes" => $notes,
					"number_of_blade" => $number_of_blade,
					"number_of_bulb" => $number_of_bulb,
					"patent" => $patent,
					"photo_cell_included" => $photo_cell_included,
					"promoted_to_frontpage" => $promoted_to_frontpage,
					"published" => $published,
					"room" => $room,
					"saftey_cable_included" => $saftey_cable_included,
					"shade_finish" => $shade_finish,
					"shade_height" => $shade_height,
					"shade_length" => $shade_length,
					"shade_qty" => $shade_qty,
					"shade_width" => $shade_width,
					"slope" => $slope,
					"small_package_shippable" => $small_package_shippable,
					"socket_type" => $socket_type,
					"title_24" => $title_24,
					"uplight" => $uplight,
					"wire_length" => $wire_length,
					"delivered_lumens" => $delivered_lumens,
					"initial_lumens" => $initial_lumens,
					"featured" => $featured,
				);
			
			if (!$is_variant) {
					$query_data['weight'] = $weight;
					$query_data['avail']  = $avail;
			}

			if ($small_item == 'N') {
					$query_data['length'] = $length;
					$query_data['width']  = $width;
					$query_data['height'] = $height;
			}

			$query_data = func_adjust_ship_box_data($query_data, $small_item, $separate_box, $items_per_box);

			func_array2update('products', $query_data, "productid = '$productid'");

			//if ($config['SEO']['clean_urls_enabled'] == 'N') {
					// Autogenerate clean URL.
					$clean_url = func_clean_url_autogenerate('P', $productid, array('product' => $product, 'productcode' => $productcode));
					$clean_url_save_in_history = false;
			//}

			// Insert/Update Clean URL.
			if (func_clean_url_resource_has_record('P', $productid)) {
					func_clean_url_update($clean_url, 'P', $productid, $clean_url_save_in_history == 'Y');
			} else {
					func_clean_url_add($clean_url, 'P', $productid);
			}

			// Update products counter for selected categories

			
			settype($categoryids, 'array');
			$categoryids = func_array_merge($categoryids, array($categoryid));

			$categoryids = func_array_merge($categoryids, func_get_category_parents($categoryids));
			func_recalc_product_count($categoryids);


			if ($active_modules['Recommended_Products']) {
					func_refresh_product_rnd_keys($productid);
			}
			
			$data = array (
					'productid'        => $productid,
					'quantity'        => 1,
					'membershipid'    => 0,
					'price'            => $product_data['price'],
			);
			
			func_array2insert('pricing', $data);

			if (
					$edit_lng == $config['default_admin_language']
					|| empty($product_info)
			) {

					$int_descr_data = array(
							'productid' => $productid,
							'product'   => $product,
							'descr'     => $descr,
							'fulldescr' => $fulldescr,
							'keywords'  => $keywords
					);

					func_array2insert('products_lng_en', $int_descr_data, true);
			}

			func_build_quick_flags($productid);
			func_build_quick_prices($productid);
			echo "Added " . $productcode . " : " . $productid . "<br />";
			return $productid;
	}
	else{
		echo "Wrong : "  . $productcode . " : " . $productid . "<br />";
		return false;
	}
}

?>