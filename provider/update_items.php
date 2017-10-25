<?php
set_time_limit(0);
ini_set('memory_limit', '512M');
error_reporting(E_ALL ^ E_NOTICE);
require './auth.php';
x_load('backoffice','category','image','product');
require_once 'fun_common.php';
$fileName = 'xls/Products 10-3-17.xlsx';

require_once 'Classes_n/PHPExcel/IOFactory.php';  
$inputFileType = PHPExcel_IOFactory::identify($fileName);
$reader = PHPExcel_IOFactory::createReader($inputFileType);
$PHPReader = $reader->load($fileName); 

function Get_data($sconfig = array()){
	global $PHPReader;
	$start_y = $sconfig["start_y"];
	$end_y = $sconfig["end_y"];
	$item_x = $sconfig["item_x"];
	$sheets = $sconfig["sheets"];
	$number_format = $sconfig["decimal"];
	if(isset($sconfig["productcode"]))$item_no = $sconfig["productcode"];
	$status = $sconfig["status"];
	$descr = $sconfig["descr"];
	$upc = $sconfig["upc"];
	$wattage = $sconfig["wattage"];
	$lumen = $sconfig["lumen"];
	$switch_type = $sconfig["switch_type"];
	$color = $sconfig["color"];
	$brand = $sconfig["brand"];
	$vendor = $sconfig["vendor"];
	$dealer_price = $sconfig["dealer_price"];
	$web_price = $sconfig["web_price"];
	$canadian_price = $sconfig["canadian_price"];
	$imap_price = $sconfig["imap_price"];
	$assembled_length = $sconfig["assembled_length"];
	$assembled_width = $sconfig["assembled_width"];
	$assembled_height = $sconfig["assembled_height"];
	$base_diameter = $sconfig["base_diameter"];
	$total_weight = $sconfig["total_weight"];
	$packlength = $sconfig["packlength"];
	$packwidth = $sconfig["packwidth"];
	$packheight = $sconfig["packheight"];
	$shade = $sconfig["shade"];
	$shade1 = $sconfig["shade1"];
	$shade_material = $sconfig["shade_material"];
	$shade_shape = $sconfig["shade_shape"];
	$shade_top1 = $sconfig["shade_top1"];
	$shade_bottom1 = $sconfig["shade_bottom1"];
	$shade_top2 = $sconfig["shade_top2"];
	$shade_bottom2 = $sconfig["shade_bottom2"];
	$shade_side = $sconfig["shade_side"];
	$shade_color = $sconfig["shade_color"];
	$shade_weight = $sconfig["shade_weight"];
	$shade_cuft = $sconfig["shade_cuft"];
	$qty_in_carton = $sconfig["qty_in_carton"];
	$number_of_cartons = $sconfig["number_of_cartons"];
	$base_color = $sconfig["base_color"];
	$base_material = $sconfig["base_material"];
	$care_instructions = $sconfig["care_instructions"];
	$master_carton_cuft = $sconfig["master_carton_cuft"];
	$carton_1_length = $sconfig["carton_1_length"];
	$carton_1_width = $sconfig["carton_1_width"];
	$carton_1_height = $sconfig["carton_1_height"];
	$carton_1_weight = $sconfig["carton_1_weight"];
	$carton_2_length = $sconfig["carton_2_length"];
	$carton_2_width = $sconfig["carton_2_width"];
	$carton_2_height = $sconfig["carton_2_height"];
	$carton_2_weight = $sconfig["carton_2_weight"];
	$carton_3_length = $sconfig["carton_3_length"];
	$carton_3_width = $sconfig["carton_3_width"];
	$carton_3_height = $sconfig["carton_3_height"];
	$carton_3_weight = $sconfig["carton_3_weight"];
	$category = $sconfig["category"];
	$type = $sconfig["type"];
	$construction = $sconfig["construction"];
	$bulb_base = $sconfig["bulb_base"];
	$attaches = $sconfig["attaches"];
	$finish = $sconfig["finish"];
	$room = $sconfig["room"];
	$style = $sconfig["style"];
	$light = $sconfig["light"];
	$country_of_origin = $sconfig["country_of_origin"];
	$ship_type = $sconfig["ship_type"];
	$assembly_required = $sconfig["assembly_required"];
	$lead_time = $sconfig["lead_time"];
	$warranty_length = $sconfig["warranty_length"];
	$warranty_term = $sconfig["warranty_term"];
	$browse_keywords = $sconfig["browse_keywords"];
	$product_feature_1 = $sconfig["product_feature_1"];
	$product_feature_2 = $sconfig["product_feature_2"];
	$product_feature_3 = $sconfig["product_feature_3"];
	$product_feature_4 = $sconfig["product_feature_4"];
	$product_feature_5 = $sconfig["product_feature_5"];
	$product_feature_6 = $sconfig["product_feature_6"];
	$product_feature_7 = $sconfig["product_feature_7"];
	$product_feature_8 = $sconfig["product_feature_8"];
	$collection_name = $sconfig["collection_name"];
	$collection_ad_copy = $sconfig["collection_ad_copy"];
	$description_ad_copy = $sconfig["description_ad_copy"];
	$general_conformity_certificate = $sconfig["general_conformity_certificate"];
	$ul_certification = $sconfig["ul_certification"];
	$etl_certification = $sconfig["etl_certification"];
	$composite_wood_carb_code_0_5 = $sconfig["composite_wood_carb_code_0_5"];
	$cpsia_small_parts_warning_code_0_6 = $sconfig["cpsia_small_parts_warning_code_0_6"];
	$ista_3a_certified = $sconfig["ista_3a_certified"];
	$freight_class = $sconfig["freight_class"];
	$nmfc_class = $sconfig["nmfc_class"];
	$harmonize_code = $sconfig["harmonize_code"];
	$image = $sconfig["image"];		$categoryid = $sconfig["categoryid"];
	
	// if(isset($sconfig["prices"])){
		// foreach($sconfig["prices"] as $k=>$p){
			// $price[$k] = $p;
		// }
	// }
		
	$data = $PHPReader->getSheet($sheets); 
	$numRows = $data->getHighestRow();
	$numColumns = $data->getHighestColumn();
	$hide = $data->getRowDimensions();
	$items = array();
	$product_data = array();
	echo "Repeat:<br />";
	
	for ($i = $start_y; $i <= $numRows&&($i<=$end_y||$end_y==0); $i++) {
		//Ìø¹ýexcel Òþ²ØÐÐ 	
		$item = trim( htmlspecialchars( $data->getCell($item_no.$i)->getCalculatedValue() ));
		// if( !isset($hide[$i]) || $hide[$i]->getVisible() != 1){
			// continue;
		// }
		//echo $item_no;
		if(empty($item)){
			continue;
		}
		
		if( !in_array($item, $items)){
			$items[] = $item;
		}else{
			echo $item."<br />";
			continue;
		}
		$info = array();
		foreach($sconfig as $field=>$td){
			if($field != 'sheets' && $field != 'decimal' && $field != 'start_y' && $field != 'end_y'){
			$info[$field] = trim( $data->getCell($td.$i)->getCalculatedValue());
			}
		}
		$product_data[] = $info;
		//print_r($info);
	}
	//print_r($product_data);
	return $product_data;
}

$sheets_config[0] = array(
	"sheets" => 0,
	"decimal" => 2,
	"start_y" => 2,
	"end_y" => 0,
	"productcode" => "A",
	"brand" => "B",
	"category" => "C",
	"style" => "D",
	"finish" => "E",
	"lumen" => "F",
	"ada_compliant" => "G",
	"canopy_height" => "H",
	"canopy_width" => "I",
	"canopy_length" => "P",
	"ballast" => "J",
	"blade_material" => "K",
	"blade_pitch" => "L",
	"blade_sweep"=> "M",
	"fulldescr"=> "N",
	"bulb_included"=> "O",
	"carton_cube_feet" => "Q",
	"carton_height"=> "R",
	"carton_length"=> "S",
	"carton_weight" => "T",
	"carton_width" => "U",
	"ceiling_to_blade" => "V",
	"ceiling_to_lowest" => "W",
	"center_to_bottom" => "X",
	"center_to_top" => "Y",
	"chain_length" => "Z",
	"clearance" => "AA",
	"list_price" => "AB",
	"price" => "AC",
	"was" => "AD",
	"color_temp" => "AE",
	"control_type" => "AF",
	"dark_sky" => "AG",
	"dimmable" => "AH",
	"downrod_1" => "AI",
	"downrod_1_outside" => "AJ",
	"downrod_2" => "AK",
	"downrod_2_outside" => "AL",
	"energy_star"=> "AM",
	"extension"=> "AN",
	"family" => "AO",
	"finish_descr" => "AP",
	"net_hanging_weight"=> "AQ",
	"iheight"=> "AR",
	"height_adjust" => "AS",
	"high_amps" => "AU",
	"high_cfm" => "AT",
	"high_rpm" => "AV",
	"high_watts" => "AW",
	"lead_wire" => "AX",
	"ilength" => "AY",
	"license_brand" => "AZ",
	"license_product" => "BA",
	"light_kit" => "BB",
	"light_kit_descr" => "BC",
	"light_type" => "BD",
	"low_amps" => "BE",
	"low_cfm" => "BF",
	"low_rpm" => "BG",
	"low_watts" => "BH",
	"master_cubic_feet" => "BI",
	"master_pack" => "BJ",
	"master_pack_height" => "BK",
	"master_pack_length" => "BL",
	"master_pack_weight"=> "BM",
	"master_pack_width"=> "BN",
	"max_bulb_wattage" => "BO",
	"max_overall_height" => "BP",
	"med_amps"=> "BQ",
	"med_cfm"=> "BR",
	"med_rpm" => "BS",
	"med_watts" => "BT",
	"min_overall_height" => "BU",
	"motor_size" => "BV",
	"multi_pack" => "BW",
	"notes" => "BX",
	"number_of_blade" => "BY",
	"number_of_bulb" => "BZ",
	"patent" => "CA",
	"photo_cell_included" => "CB",
	"promoted_to_frontpage" => "CC",
	"published" => "CD",
	"room" => "CE",
	"saftey_cable_included" => "CF",
	"shade_finish" => "CG",
	"shade_height" => "CH",
	"shade_length" => "CI",
	"shade_qty" => "CJ",
	"shade_width" => "CK",
	"product" => "CL",
	"slope" => "CM",
	"small_package_shippable" => "CN",
	"socket_type" => "CO",
	"title_24" => "CP",
	"uplight" => "CQ",
	"iwidth" => "CR",
	"wire_length" => "CS",
	"forsale" => "CT",
	"delivered_lumens" => "CU",
	"initial_lumens" => "CV",
	"featured" => "CW",
);

$product_data_1 = array();
$product_data_1 = Get_data($sheets_config[0]);
foreach($product_data_1 as $k=>$v){
	$brand = explode(',', $v['brand']);
	$category = explode(',', $v['category']);
	$style = explode(',', $v['style']);
	
	$categoryids = array_merge($brand, $category, $style);
	
	$product_data_1[$k]['categoryids'] = array_map('trim', $categoryids);
	
	if($v['finish'] == 'N/A')$product_data_1[$k]['finish'] = '';
	if($v['ada_compliant'])$product_data_1[$k]['ada_compliant'] = 'Y';
	if($v['clearance'])$product_data_1[$k]['clearance'] = 'Y';
	if(empty($v['list_price']))$product_data_1[$k]['list_price'] = 0;
	if(empty($v['price']))$product_data_1[$k]['price'] = 0;
	if(empty($v['was']))$product_data_1[$k]['was'] = 0;
	if(!empty($v['dark_sky']))$product_data_1[$k]['dark_sky'] = 'Y';
	if(!empty($v['dimmable']))$product_data_1[$k]['dimmable'] = 'Y';
	if(!empty($v['energy_star']))$product_data_1[$k]['energy_star'] = 'Y';
	if(!empty($v['height_adjust']))$product_data_1[$k]['height_adjust'] = 'Y';
	if(!empty($v['license_product']))$product_data_1[$k]['license_product'] = 'Y';
	if(!empty($v['light_kit']))$product_data_1[$k]['light_kit'] = 'Y';
	if($v['promoted_to_frontpage'] == 'Yes')$product_data_1[$k]['promoted_to_frontpage'] = 'Y'; else $product_data_1[$k]['promoted_to_frontpage'] = 'N';
	if($v['published'] == 'Yes')$product_data_1[$k]['published'] = 'Y'; else $product_data_1[$k]['published'] = 'N';
	if(!empty($v['saftey_cable_included']))$product_data_1[$k]['saftey_cable_included'] = 'Y';
	if(!empty($v['slope']))$product_data_1[$k]['slope'] = 'Y';
	if(!empty($v['small_package_shippable']))$product_data_1[$k]['small_package_shippable'] = 'Y';
	if(!empty($v['title_24']))$product_data_1[$k]['title_24'] = 'Y';
	if(!empty($v['forsale']))$product_data_1[$k]['forsale'] = 'N';else $product_data_1[$k]['forsale'] = 'Y';
	if(!empty($v['featured']))$product_data_1[$k]['featured'] = 'Y';

	if($v['room']){
		if($v['room'] != 'Outdoor')
		$product_data_1[$k]['room'] = $v['room'] . ', ' . 'Indoor';
	}
	if($v['product'])
	$product_data_1[$k]['descr'] = $v['product'];
	else
	$product_data_1[$k]['descr'] = 'shoot descr';
	
	$product_data_1[$k]['product'] = $v['productcode'];
}
foreach($product_data_1 as $p){
	$productcode = $p['productcode'];
	$productid = func_query_first_cell("SELECT productid FROM $sql_tbl[products] WHERE productcode='$productcode'");
	if($p['status'] == 'D'){
		if($productid)
		func_delete_product($productid);
	}elseif($productid){
			
		$forsale = $p["forsale"];
		$list_price = $p["list_price"];
		$categoryids = $p["categoryids"];
		$categoryid = array_shift($categoryids);
		$price = $p["price"];
		$was = $p["was"];
		
		$product = addslashes($p["product"]);
		$descr = addslashes($p["descr"]);
		$fulldescr =  addslashes($p["fulldescr"]);
		$ada_compliant = $p["ada_compliant"];
		$canopy_height = $p["canopy_height"];
		$canopy_width = $p["canopy_width"];
		$canopy_length = $p["canopy_length"];
		$ballast = addslashes($p["ballast"]);
		$blade_material = addslashes($p["blade_material"]);
		$blade_pitch = addslashes($p["blade_pitch"]);
		$blade_sweep = $p["blade_sweep"];
		$fulldescr = addslashes($p["fulldescr"]);
		$bulb_included = $p["bulb_included"];
		$carton_cube_feet = $p["carton_cube_feet"];
		$carton_height = $p["carton_height"];
		$carton_length = $p["carton_length"];
		$carton_weight = $p["carton_weight"];
		$carton_width = $p["carton_width"];
		$ceiling_to_blade = $p["ceiling_to_blade"];
		$ceiling_to_lowest = $p["ceiling_to_lowest"];
		$center_to_bottom = $p["center_to_bottom"];
		$center_to_top = $p["center_to_top"];
		$chain_length = addslashes($p["chain_length"]);
		$clearance = $p["clearance"];
		$color_temp = $p["color_temp"];
		$control_type = addslashes($p["control_type"]);
		$dark_sky = $p["dark_sky"];
		$dimmable = $p["dimmable"];
		$downrod_1 = addslashes($p["downrod_1"]);
		$downrod_1_outside = addslashes($p["downrod_1_outside"]);
		$downrod_2 = addslashes($p["downrod_2"]);
		$downrod_2_outside = addslashes($p["downrod_2_outside"]);
		$energy_star = $p["energy_star"];
		$extension = addslashes($p["extension"]);
		$family = addslashes($p["family"]);
		$finish_descr = addslashes($p["finish_descr"]);
		$net_hanging_weight = $p["net_hanging_weight"];
		$iheight = addslashes($p["iheight"]);
		$height_adjust = $p["height_adjust"];
		$high_amps = $p["high_amps"];
		$high_cfm = addslashes($p["high_cfm"]);
		$high_rpm = $p["high_rpm"];
		$high_watts = $p["high_watts"];
		$lead_wire = addslashes($p["lead_wire"]);
		$ilength = $p["ilength"];
		$license_brand = addslashes($p["license_brand"]);
		$license_product = $p["license_product"];
		$light_kit = $p["light_kit"];
		$light_kit_descr = addslashes($p["light_kit_descr"]);
		$light_type = addslashes($p["light_type"]);
		$low_amps = $p["low_amps"];
		$low_cfm = $p["low_cfm"];
		$low_rpm = $p["low_rpm"];
		$low_watts = $p["low_watts"];
		$master_cubic_feet = $p["master_cubic_feet"];
		$master_pack = $p["master_pack"];
		$master_pack_height = $p["master_pack_height"];
		$master_pack_length = $p["master_pack_length"];
		$master_pack_weight = $p["master_pack_weight"];
		$master_pack_width = $p["master_pack_width"];
		$max_bulb_wattage = addslashes($p["max_bulb_wattage"]);
		$max_overall_height = $p["max_overall_height"];
		$med_amps = $p["med_amps"];
		$med_cfm = $p["med_cfm"];
		$med_rpm = $p["med_rpm"];
		$med_watts = $p["med_watts"];
		$min_overall_height = $p["min_overall_height"];
		$motor_size = addslashes($p["motor_size"]);
		$multi_pack = $p["multi_pack"];
		$notes = addslashes($p["notes"]);
		$number_of_blade = $p["number_of_blade"];
		$number_of_bulb = $p["number_of_bulb"];
		$patent = addslashes($p["patent"]);
		$photo_cell_included = $p["photo_cell_included"];
		$promoted_to_frontpage = $p["promoted_to_frontpage"];
		$published = $p["published"];
		$room = addslashes($p["room"]);
		$saftey_cable_included = $p["saftey_cable_included"];
		$shade_finish = addslashes($p["shade_finish"]);
		$shade_height = $p["shade_height"];
		$shade_length = $p["shade_length"];
		$shade_qty = $p["shade_qty"];
		$shade_width = $p["shade_width"];
		$slope = $p["slope"];
		$small_package_shippable = $p["small_package_shippable"];
		$socket_type = addslashes($p["socket_type"]);
		$title_24 = $p["title_24"];
		$title_20 = $p["title_20"];
		$uplight = $p["uplight"];
		$iwidth = addslashes($p["iwidth"]);
		$wire_length = addslashes($p["wire_length"]);
		$delivered_lumens = addslashes($p["delivered_lumens"]);
		$initial_lumens = addslashes($p["initial_lumens"]);
		$featured = $p["featured"];
			
		if($p["image"]){
			func_delete_image($productid);
			$ext = substr(strrchr($p["image"], '.'), 1);
			$file = basename($p["image"],".".$ext);	
			save_image('../imgtemp/'.$p["image"],$productid,$file);
		}
		
		db_query("DELETE FROM $sql_tbl[products_categories] WHERE productid = '$productid'");
		$query_data_cat = array(
				'categoryid' => $categoryid,
				'productid'  => $productid,
				'main'       => 'Y'
		);
		func_array2insert('products_categories', $query_data_cat);
		
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
				
				'forsale'           => $forsale,
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
		
		func_array2update('products', $query_data, "productid = '$productid'");
		
		settype($categoryids, 'array');
		$categoryids = func_array_merge($categoryids, array($categoryid));

		$categoryids = func_array_merge($categoryids, func_get_category_parents($categoryids));
		func_recalc_product_count($categoryids);

		db_query("DELETE FROM $sql_tbl[pricing] WHERE productid = '$productid'");
		$data = array (
				'productid'        => $productid,
				'quantity'        => 1,
				'membershipid'    => 0,
				'price'            => $p['price'],
		);
		
		func_array2insert('pricing', $data);
		
		$int_descr_data = array(
				'productid' => $productid,
				'product'   => $product,
				'descr'     => $descr,
				'fulldescr' => $fulldescr,
				'keywords'  => $keywords
		);

		func_array2insert('products_lng_en', $int_descr_data, true);
		
		func_build_quick_flags($productid);
		func_build_quick_prices($productid);
			
	}else{
		import_product($p);
	}
}
// print_r($product_data_1);
//echo count($product_data_1);
// foreach($product_data_1 as $k=>$p){
	// if(!file_exists('../imgtemp/' .$p["image"])) echo $p["productcode"] . "<br />";
// }
// foreach($product_data_1 as $p){
	// $result = import_product($p); if(!$result)break;
// }
//print_r($product_data_1);
	//get_file("http://www.baidu.com/img/baidu_logo.gif","file","baidu.jpg");

?>