<?php

static $registry = null;

// Error Handler
function error_handler_for_export_import($errno, $errstr, $errfile, $errline) {
	global $registry;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}
	
	$config = $registry->get('config');
	$url = $registry->get('url');
	$request = $registry->get('request');
	$session = $registry->get('session');
	$log = $registry->get('log');
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	if (($errors=='Warning') || ($errors=='Unknown')) {
		return true;
	}

	if (($errors != "Fatal Error") && isset($request->get['route']) && ($request->get['route']!='tool/export_import/download'))  {
		if ($config->get('config_error_display')) {
			echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
		}
	} else {
		$session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
		$token = $request->get['token'];
		$link = $url->link( 'tool/export_import', 'token='.$token, 'SSL' );
		header('Status: ' . 302);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $link));
		exit();
	}

	return true;
}


function fatal_error_shutdown_handler_for_export_import()
{
	$last_error = error_get_last();
	if ($last_error['type'] === E_ERROR) {
		// fatal error
		error_handler_for_export_import(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
	}
}


class ModelToolExportImport extends Model {

	private $error = array();

	protected function clean( &$str, $allowBlanks=false ) {
		$result = "";
		$n = strlen( $str );
		for ($m=0; $m<$n; $m++) {
			$ch = substr( $str, $m, 1 );
			if (($ch==" ") && (!$allowBlanks) || ($ch=="\n") || ($ch=="\r") || ($ch=="\t") || ($ch=="\0") || ($ch=="\x0B")) {
				continue;
			}
			$result .= $ch;
		}
		return $result;
	}


	protected function multiquery( $sql ) {
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);
			if ($sql) {
				$this->db->query($sql);
			}
		}
	}


	protected function startsWith( $haystack, $needle ) {
		if (strlen( $haystack ) < strlen( $needle )) {
			return false;
		}
		return (substr( $haystack, 0, strlen($needle) ) == $needle);
	}

	protected function endsWith( $haystack, $needle ) {
		if (strlen( $haystack ) < strlen( $needle )) {
			return false;
		}
		return (substr( $haystack, strlen($haystack)-strlen($needle), strlen($needle) ) == $needle);
	}

	protected function getManufacturers() {
		// find all manufacturers already stored in the database
		$manufacturer_ids = array();
		$sql  = "SELECT manufacturer_id, name FROM ".DB_PREFIX."manufacturer";
		$result = $this->db->query( $sql );
		$manufacturers = array();
		foreach ($result->rows as $row) {
			$manufacturer_id = $row['manufacturer_id'];
			$name = $row['name'];
			if (!isset($manufacturers[$name])) {
				$manufacturers[$name] = array();
			}
			if (!isset($manufacturers[$name]['manufacturer_id'])) {
				$manufacturers[$name]['manufacturer_id'] = $manufacturer_id;
			}
		}
		return $manufacturers;
	}


	protected function storeManufacturerIntoDatabase( &$manufacturers, $name) {
		if (!isset($manufacturers[$name]['manufacturer_id'])) {
			$this->db->query("INSERT INTO ".DB_PREFIX."manufacturer SET name = '".$this->db->escape($name)."', image='', sort_order = '0'");
			$manufacturer_id = $this->db->getLastId();
			if (!isset($manufacturers[$name])) {
				$manufacturers[$name] = array();
			}
			$manufacturers[$name]['manufacturer_id'] = $manufacturer_id;
		}
	}

	protected function getAvailableProductIds(&$data) {
		// get all product_ids from the database
		$sql = "SELECT `product_id` FROM `".DB_PREFIX."product`;";
		$result = $this->db->query( $sql );
		$product_ids = array();
		foreach ($result->rows as $row) {
			$product_ids[$row['product_id']] = $row['product_id'];
		}

		// we are only interested in above found product_ids if they are also listed in the Products worksheet
		$available_product_ids = array();
		$i = 0;
		$k = $data->getHighestRow();
		for ($i=0; $i<$k; $i+=1) {
			$j = 1;
			if ($i==0) {
				continue;
			}
			$product_id = trim($this->getCell($data,$i,$j++));
			if ($product_id=="") {
				continue;
			}
			if (array_key_exists($product_id,$product_ids)) {
				$available_product_ids[$product_id] = $product_id;
			}
		}

		return $available_product_ids;
	}


	protected function getAvailableCategoryIds() {
		$sql = "SELECT `category_id` FROM `".DB_PREFIX."category`;";
		$result = $this->db->query( $sql );
		$category_ids = array();
		foreach ($result->rows as $row) {
			$category_ids[$row['category_id']] = $row['category_id'];
		}
		return $category_ids;
	}


	protected function storeCategoryIntoDatabase( &$category ) {
		// extract the category details
		$category_id = $category['category_id'];
		$image_name = $category['image'];
		$parent_id = $category['parent_id'];
		$top = $category['top'];
		$top = ((strtoupper($top)=="TRUE") || (strtoupper($top)=="YES") || (strtoupper($top)=="ENABLED")) ? 1 : 0;
		$sort_order = $category['sort_order'];
		$date_added = $category['date_added'];
		$date_modified = $category['date_modified'];
		$name = $category['name'];
		$description = $category['description'];

		$store_ids = $category['store_ids'];
		$status = $category['status'];
		$status = ((strtoupper($status)=="TRUE") || (strtoupper($status)=="YES") || (strtoupper($status)=="ENABLED")) ? 1 : 0;

	
		$name = isset($name) ? $this->db->escape($name) : '';
		$description = isset($description) ? $this->db->escape($description) : '';

		// generate and execute SQL for inserting the category
		$sql = "INSERT INTO `".DB_PREFIX."category` (`category_id`, `image`, `parent_id`, `top`,`sort_order`, `date_added`, `date_modified`, `status`,`name`, `description`) VALUES ";
		$sql .= "( $category_id, '$image_name', $parent_id, $top, $sort_order, ";
		$sql .= ($date_added=='NOW()') ? "$date_added," : "'$date_added',";
		$sql .= ($date_modified=='NOW()') ? "$date_modified," : "'$date_modified',";
		$sql .= " $status,'$name','$description' );";
		$this->db->query( $sql );

		foreach ($store_ids as $store_id) {
			$sql = "INSERT INTO `".DB_PREFIX."category_to_store` (`category_id`,`store_id`) VALUES ($category_id,$store_id);";
			$this->db->query($sql);
		}
	}


	protected function deleteCategory( $category_id ) {
		$sql  = "DELETE FROM `".DB_PREFIX."category` WHERE `category_id` = '".(int)$category_id."' ;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."category_to_store` WHERE `category_id` = '".(int)$category_id."' ;\n";
		$this->multiquery( $sql );
		$sql = "SHOW TABLES LIKE \"".DB_PREFIX."category_path\"";
		$query = $this->db->query( $sql );
		if ($query->num_rows) {
			$sql = "DELETE FROM `".DB_PREFIX."category_path` WHERE `category_id` = '".(int)$category_id."'";
			$this->db->query( $sql );
		}
	}


	protected function deleteCategories() {
		$sql  = "TRUNCATE TABLE `".DB_PREFIX."category`;\n";
		$sql .= "TRUNCATE TABLE `".DB_PREFIX."category_to_store`;\n";
		$this->multiquery( $sql );
		$sql = "SHOW TABLES LIKE \"".DB_PREFIX."category_path\"";
		$query = $this->db->query( $sql );
		if ($query->num_rows) {
			$sql = "TRUNCATE TABLE `".DB_PREFIX."category_path`";
			$this->db->query( $sql );
		}
	}


	// function for reading additional cells in class extensions
	protected function moreCategoryCells( $i, &$j, &$worksheet, &$category ) {
		return;
	}


	protected function uploadCategories( &$reader, $incremental ) {
		// get worksheet if there
		$data = $reader->getSheetByName( 'Categories' );
		if ($data==null) {
			return;
		}

		// if incremental then find current category IDs else delete all old categories
		$available_category_ids = array();
		if ($incremental) {
			$available_category_ids = $this->getAvailableCategoryIds();
		} else {
			$this->deleteCategories(); 						
		}

		$first_row = array();
		$i = 0;
		$k = $data->getHighestRow();

		for ($i=0; $i<$k; $i+=1) {
			if ($i==0) {
				$max_col = PHPExcel_Cell::columnIndexFromString( $data->getHighestColumn() );
				for ($j=1; $j<=$max_col; $j+=1) {
					$first_row[] = $this->getCell($data,$i,$j);
				}
				continue;
			}
			$j = 1;
			$category_id = trim($this->getCell($data,$i,$j++));
			if ($category_id=="") {
				continue;
			}
			$parent_id = $this->getCell($data,$i,$j++,'0');
			$name = $this->getCell($data,$i,$j++);
			$name = htmlspecialchars( $name );

			$top = $this->getCell($data,$i,$j++,($parent_id=='0')?'true':'false');

			$sort_order = $this->getCell($data,$i,$j++,'0');
			$image_name = trim($this->getCell($data,$i,$j++));
			$date_added = trim($this->getCell($data,$i,$j++));
			$date_added = ((is_string($date_added)) && (strlen($date_added)>0)) ? $date_added : "NOW()";
			$date_modified = trim($this->getCell($data,$i,$j++));
			$date_modified = ((is_string($date_modified)) && (strlen($date_modified)>0)) ? $date_modified : "NOW()";

			$description = $this->getCell($data,$i,$j++);
			$description = htmlspecialchars( $description );

			$store_ids = $this->getCell($data,$i,$j++);

			$status = $this->getCell($data,$i,$j++,'true');
			$category = array();
			$category['category_id'] = $category_id;
			$category['image'] = $image_name;
			$category['parent_id'] = $parent_id;
			$category['sort_order'] = $sort_order;
			$category['date_added'] = $date_added;
			$category['date_modified'] = $date_modified;
			$category['name'] = $name;
			$category['top'] = $top;

			$category['description'] = $description;

			$store_ids = trim( $this->clean($store_ids, false) );
			$category['store_ids'] = ($store_ids=="") ? array() : explode( ",", $store_ids );
			if ($category['store_ids']===false) {
				$category['store_ids'] = array();
			}

			$category['status'] = $status;
			if ($incremental) {
				if ($available_category_ids) {
					if (in_array((int)$category_id,$available_category_ids)) {
						$this->deleteCategory( $category_id );
					}
				}
			}
			$this->moreCategoryCells( $i, $j, $data, $category );
			$this->storeCategoryIntoDatabase( $category );
		}

		// restore category paths for faster lookups on the frontend (only for newer OpenCart versions)
		$this->load->model( 'catalog/category' );
		if (method_exists($this->model_catalog_category,'repairCategories')) {
			$this->model_catalog_category->repairCategories(0);
		}
	}

	protected function storeProductIntoDatabase( &$product, &$product_fields, &$manufacturers ) {
		// extract the product details
		$product_id = $product['product_id'];
		$name = $product['name'];
		$categories = $product['categories'];
		$quantity = $product['quantity'];
		$model = $this->db->escape($product['model']);
		$manufacturer_name = $product['manufacturer_name'];
		$image = $product['image'];
		$price = trim($product['price']);


		$date_added = $product['date_added'];
		$date_modified = $product['date_modified'];
		$date_available = $product['date_available'];

		$status = $product['status'];
		$status = ((strtoupper($status)=="TRUE") || (strtoupper($status)=="YES") || (strtoupper($status)=="ENABLED")) ? 1 : 0;
		$tax_id = $product['tax_id'];

		$description = $product['description'];
		$meta_description = $product['meta_description'];
		
		$location = $this->db->escape($product['location']);

		$store_ids = $product['store_ids'];

		$related_ids = $product['related_ids'];

		$sort_order = $product['sort_order'];
		if ($manufacturer_name) {
			$this->storeManufacturerIntoDatabase( $manufacturers, $manufacturer_name );
			$manufacturer_id = $manufacturers[$manufacturer_name]['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}

		// generate and execute SQL for inserting the product
		$sql  = "INSERT INTO `".DB_PREFIX."product` (`product_id`,`quantity`,";

		$sql .= "`location`,`model`,`manufacturer_id`,`image`,`price`,`date_added`,`date_modified`,`date_available`,`status`,";
		$sql .= "`tax_id`,`sort_order`) VALUES ";
		$sql .= "($product_id,$quantity,";
		$sql .= "'$location','$model',$manufacturer_id,'$image',$price,";
		$sql .= ($date_added=='NOW()') ? "$date_added," : "'$date_added',";
		$sql .= ($date_modified=='NOW()') ? "$date_modified," : "'$date_modified',";
		$sql .= ($date_available=='NOW()') ? "$date_available," : "'$date_available',";
		$sql .= "$status,";
		$sql .= "$tax_id,'$sort_order');";
		$this->db->query($sql);
	
	
	
		$name = isset($name) ? $this->db->escape($name) : '';
		$description = isset($description) ? $this->db->escape($description) : '';
		$meta_description = isset($meta_description) ? $this->db->escape($meta_description) : '';
		$sql  = "INSERT INTO `".DB_PREFIX."product_description` (`product_id`,  `name`, `description`, `meta_description`) VALUES ";
		$sql .= "( $product_id, '$name', '$description', '$meta_description' );";
		$this->db->query( $sql );

		if (count($categories) > 0) {
			$sql = "INSERT INTO `".DB_PREFIX."product_to_category` (`product_id`,`category_id`) VALUES ";
			$first = true;
			foreach ($categories as $category_id) {
				$sql .= ($first) ? "\n" : ",\n";
				$first = false;
				$sql .= "($product_id,$category_id)";
			}
			$sql .= ";";
			$this->db->query($sql);
		}

		foreach ($related_ids as $related_id) {
			$sql = "INSERT INTO `".DB_PREFIX."product_related` (`product_id`,`related_id`) VALUES ($product_id,$related_id);";
			$this->db->query($sql);
		}
	}


	protected function deleteProducts( ) {
		$sql  = "TRUNCATE TABLE `".DB_PREFIX."product`;\n";
		$sql .= "TRUNCATE TABLE `".DB_PREFIX."product_description`;\n";
		$sql .= "TRUNCATE TABLE `".DB_PREFIX."product_to_category`;\n";
		//$sql .= "TRUNCATE TABLE `".DB_PREFIX."product_to_store`;\n";
		$sql .= "TRUNCATE TABLE `".DB_PREFIX."product_related`;\n";
		$this->multiquery( $sql );
	}


	protected function deleteProduct( $product_id ) {
		$sql  = "DELETE FROM `".DB_PREFIX."product` WHERE `product_id` = '$product_id';\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_description` WHERE `product_id` = '$product_id';\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_to_category` WHERE `product_id` = '$product_id';\n";
		//$sql .= "DELETE FROM `".DB_PREFIX."product_to_store` WHERE `product_id` = '$product_id';\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_related` WHERE `product_id` = '$product_id';\n";
		$this->multiquery( $sql );
	}


	// function for reading additional cells in class extensions
	protected function moreProductCells( $i, &$j, &$worksheet, &$product ) {
		return;
	}


	protected function uploadProducts( &$reader, $incremental, &$available_product_ids=array() ) {
		// get worksheet, if not there return immediately
		$data = $reader->getSheetByName( 'Products' );
		if ($data==null) {
			return;
		}
		// if incremental then find current product IDs else delete all old products
		$available_product_ids = array();
		if ($incremental) {
			$available_product_ids = $this->getAvailableProductIds($data);
		} else {
			$this->deleteProducts();
		}

		// find existing manufacturers, only newly specified manufacturers will be added
		$manufacturers = $this->getManufacturers();

		// get list of the field names, some are only available for certain OpenCart versions
		$query = $this->db->query( "DESCRIBE `".DB_PREFIX."product`" );
		$product_fields = array();
		foreach ($query->rows as $row) {
			$product_fields[] = $row['Field'];
		}

		// load the worksheet cells and store them to the database
		$first_row = array();
		$i = 0;
		$k = $data->getHighestRow();
		for ($i=0; $i<$k; $i+=1) {
			if ($i==0) {
				$max_col = PHPExcel_Cell::columnIndexFromString( $data->getHighestColumn() );
				for ($j=1; $j<=$max_col; $j+=1) {
					$first_row[] = $this->getCell($data,$i,$j);
				}
				continue;
			}
			$j = 1;
			$product_id = trim($this->getCell($data,$i,$j++));
			if ($product_id=="") {
				continue;
			}

			$name = $this->getCell($data,$i,$j++);
			$name = htmlspecialchars( $name );
			$categories = $this->getCell($data,$i,$j++);

			$location = $this->getCell($data,$i,$j++,'');
			$quantity = $this->getCell($data,$i,$j++,'0');
			$model = $this->getCell($data,$i,$j++,'   ');
			$manufacturer_name = $this->getCell($data,$i,$j++);
			$image_name = $this->getCell($data,$i,$j++);

			$price = $this->getCell($data,$i,$j++,'0.00');

			$date_added = $this->getCell($data,$i,$j++);
			$date_added = ((is_string($date_added)) && (strlen($date_added)>0)) ? $date_added : "NOW()";
			$date_modified = $this->getCell($data,$i,$j++);
			$date_modified = ((is_string($date_modified)) && (strlen($date_modified)>0)) ? $date_modified : "NOW()";
			$date_available = $this->getCell($data,$i,$j++);
			$date_available = ((is_string($date_available)) && (strlen($date_available)>0)) ? $date_available : "NOW()";

			$status = $this->getCell($data,$i,$j++,'true');
			$tax_id = $this->getCell($data,$i,$j++,'0');

			$description = $this->getCell($data,$i,$j++);
			$description = htmlspecialchars( $description );

			$meta_description = $this->getCell($data,$i,$j++);
			$meta_description = htmlspecialchars( $meta_description );
	
			$store_ids = $this->getCell($data,$i,$j++);

			$related = $this->getCell($data,$i,$j++);
			//var_dump($related);

			$sort_order = $this->getCell($data,$i,$j++,'0');

			$product = array();
			$product['product_id'] = $product_id;
			$product['name'] = $name;
			$categories = trim( $this->clean($categories, false) );
			$product['categories'] = ($categories=="") ? array() : explode( ",", $categories );
			if ($product['categories']===false) {
				$product['categories'] = array();
			}
			$product['quantity'] = $quantity;
			$product['model'] = $model;
			$product['manufacturer_name'] = $manufacturer_name;
			$product['image'] = $image_name;

			$product['price'] = $price;

			$product['date_added'] = $date_added;
			$product['date_modified'] = $date_modified;
			$product['date_available'] = $date_available;

			$product['status'] = $status;
			$product['tax_id'] = $tax_id;

			$product['description'] = $description;

			$product['meta_description'] = $meta_description;

			$product['location'] = $location;

			$store_ids = trim( $this->clean($store_ids, false) );
			$product['store_ids'] = ($store_ids=="") ? array() : explode( ",", $store_ids );
			if ($product['store_ids']===false) {
				$product['store_ids'] = array();
			}
			$product['related_ids'] = ($related=="") ? array() : explode( ",", $related );
			if ($product['related_ids']===false) {
				$product['related_ids'] = array();
			}

			$product['sort_order'] = $sort_order;

			if ($incremental) {
				if ($available_product_ids) {
					if (in_array((int)$product_id,$available_product_ids)) {
						$this->deleteProduct( $product_id );
					}
				}
			}
			$this->moreProductCells( $i, $j, $data, $product );
			$this->storeProductIntoDatabase( $product, $product_fields, $manufacturers );
		}
	}


	protected function storeAdditionalImageIntoDatabase( &$image, &$old_product_image_ids, $exist_sort_order=true ) {
		$product_id = $image['product_id'];
		$image_name = $image['image_name'];
		if ($exist_sort_order) {
			$sort_order = $image['sort_order'];
		}
		if (isset($old_product_image_ids[$product_id][$image_name])) {
			$product_image_id = $old_product_image_ids[$product_id][$image_name];
			if ($exist_sort_order) {
				$sql  = "INSERT INTO `".DB_PREFIX."product_image` (`product_image_id`,`product_id`,`image`,`sort_order` ) VALUES "; 
				$sql .= "($product_image_id,$product_id,'".$this->db->escape($image_name)."',$sort_order)";
			} else {
				$sql  = "INSERT INTO `".DB_PREFIX."product_image` (`product_image_id`,`product_id`,`image` ) VALUES "; 
				$sql .= "($product_image_id,$product_id,'".$this->db->escape($image_name)."')";
			}
			$this->db->query($sql);
			unset($old_product_image_ids[$product_id][$image_name]);
		} else {
			if ($exist_sort_order) {
				$sql  = "INSERT INTO `".DB_PREFIX."product_image` (`product_id`,`image`,`sort_order` ) VALUES "; 
				$sql .= "($product_id,'".$this->db->escape($image_name)."',$sort_order)";
			} else {
				$sql  = "INSERT INTO `".DB_PREFIX."product_image` (`product_id`,`image` ) VALUES "; 
				$sql .= "($product_id,'".$this->db->escape($image_name)."')";
			}
			$this->db->query($sql);
		}
	}


	protected function deleteAdditionalImages() {
		$sql = "TRUNCATE TABLE `".DB_PREFIX."product_image`";
		$this->db->query( $sql );
	}


	protected function deleteAdditionalImage( $product_id ) {
		$sql = "SELECT product_image_id, product_id, image FROM `".DB_PREFIX."product_image` WHERE product_id='".(int)$product_id."'";
		$query = $this->db->query( $sql );
		$old_product_image_ids = array();
		foreach ($query->rows as $row) {
			$product_image_id = $row['product_image_id'];
			$product_id = $row['product_id'];
			$image_name = $row['image'];
			$old_product_image_ids[$product_id][$image_name] = $product_image_id;
		}
		$sql = "DELETE FROM `".DB_PREFIX."product_image` WHERE product_id='".(int)$product_id."'";
		$this->db->query( $sql );
		return $old_product_image_ids;
	}


	protected function deleteUnlistedAdditionalImages( &$unlisted_product_ids ) {
		foreach ($unlisted_product_ids as $product_id) {
			$sql = "DELETE FROM `".DB_PREFIX."product_image` WHERE product_id='".(int)$product_id."'";
			$this->db->query( $sql );
		}
	}


	// function for reading additional cells in class extensions
	protected function moreAdditionalImageCells( $i, &$j, &$worksheet, &$image ) {
		return;
	}


	protected function uploadAdditionalImages( &$reader, $incremental, &$available_product_ids ) {
		// get worksheet, if not there return immediately
		$data = $reader->getSheetByName( 'AdditionalImages' );
		if ($data==null) {
			return;
		}

		// if incremental then find current product IDs else delete all old additional images
		if ($incremental) {
			$unlisted_product_ids = $available_product_ids;
		} else {
			$this->deleteAdditionalImages();
		}

		// check for the existence of product_image.sort_order field
		$sql = "SHOW COLUMNS FROM `".DB_PREFIX."product_image` LIKE 'sort_order'";
		$query = $this->db->query( $sql );
		$exist_sort_order = ($query->num_rows > 0) ? true : false;

		// load the worksheet cells and store them to the database
		$old_product_image_ids = array();
		$previous_product_id = 0;
		$i = 0;
		$k = $data->getHighestRow();
		for ($i=0; $i<$k; $i+=1) {
			$j= 1;
			if ($i==0) {
				continue;
			}
			$product_id = trim($this->getCell($data,$i,$j++));
			if ($product_id=="") {
				continue;
			}
			$image_name = $this->getCell($data,$i,$j++,'');
			if ($exist_sort_order) {
				$sort_order = $this->getCell($data,$i,$j++,'0');
			}
			$image = array();
			$image['product_id'] = $product_id;
			$image['image_name'] = $image_name;
			if ($exist_sort_order) {
				$image['sort_order'] = $sort_order;
			}
			if (($incremental) && ($product_id != $previous_product_id)) {
				$old_product_image_ids = array();
				if ($available_product_ids) {
					if (in_array((int)$product_id,$available_product_ids)) {
						$old_product_image_ids = $this->deleteAdditionalImage( $product_id );
						if (isset($unlisted_product_ids[$product_id])) {
							unset($unlisted_product_ids[$product_id]);
						}
					}
				}
			}
			$this->moreAdditionalImageCells( $i, $j, $data, $image );
			$this->storeAdditionalImageIntoDatabase( $image, $old_product_image_ids, $exist_sort_order );
			$previous_product_id = $product_id;
		}
		if ($incremental) {
			$this->deleteUnlistedAdditionalImages( $unlisted_product_ids );
		}
	}


	function getCell(&$worksheet,$row,$col,$default_val='') {
		$col -= 1; // we use 1-based, PHPExcel uses 0-based column index
		$row += 1; // we use 0-based, PHPExcel uses 1-based row index
		$val = ($worksheet->cellExistsByColumnAndRow($col,$row)) ? $worksheet->getCellByColumnAndRow($col,$row)->getValue() : $default_val;
		if ($val===null) {
			$val = $default_val;
		}
		return $val;
	}


	function validateHeading( &$data, &$expected ) {
		$heading = array();
		$k = PHPExcel_Cell::columnIndexFromString( $data->getHighestColumn() );
		$i = 0;
		for ($j=1; $j <= $k; $j+=1) {
			$entry = $this->getCell($data,$i,$j);
			$heading[] = strtolower($entry);
		}
		//var_dump($heading);
		
		//var_dump($expected);
		for ($i=0; $i < count($expected); $i+=1) {
			if (!isset($heading[$i])) {
				return false;
			}
			if ($heading[$i] != $expected[$i]) {
				return false;
			}
		}
		return true;
	}


	protected function validateCategories( &$reader ) {
		$data = $reader->getSheetByName( 'Categories' );
		if ($data==null) {
			return true;
		}

		$expected_heading = array
			( "category_id", "parent_id", "name", "top", "sort_order", "image_name", "date_added", "date_modified", "description", "store_ids", "status"  );
		return $this->validateHeading( $data, $expected_heading );
	}


	protected function validateProducts( &$reader ) {
		$data = $reader->getSheetByName( 'Products' );
		if ($data==null) {
			return true;
		}

		// get list of the field names, some are only available for certain OpenCart versions
		$query = $this->db->query( "DESCRIBE `".DB_PREFIX."product`" );
		$product_fields = array();
		foreach ($query->rows as $row) {
			$product_fields[] = $row['Field'];
		}

		$expected_heading = array
		( "product_id", "name", "categories" );

		$expected_heading = array_merge( $expected_heading, array( "location", "quantity", "model", "manufacturer", "image_name", "price",  "date_added", "date_modified", "date_available", "status", "tax_id") );

		$expected_heading = array_merge( $expected_heading, array( "description", "meta_description" , "store_ids", "related_ids", "sort_order" ) );
	
		return $this->validateHeading( $data, $expected_heading);
	}


	protected function validateAdditionalImages( &$reader ) {
		$data = $reader->getSheetByName( 'AdditionalImages' );
		if ($data==null) {
			return true;
		}
		$sql = "SHOW COLUMNS FROM `".DB_PREFIX."product_image` LIKE 'sort_order'";
		$query = $this->db->query( $sql );
		$exist_sort_order = ($query->num_rows > 0) ? true : false;
		if ($exist_sort_order) {
			$expected_heading = array( "product_id", "image", "sort_order" );
		} else {
			$expected_heading = array( "product_id", "image" );
		}
		return $this->validateHeading( $data, $expected_heading );
	}

	protected function validateUpload( &$reader )
	{
		$ok = true;

		// worksheets must have correct heading rows
		if (!$this->validateCategories( $reader )) {
			$this->log->write( $this->language->get('error_categories_header') );
			$ok = false;
		}
		if (!$this->validateProducts( $reader )) {
			$this->log->write( $this->language->get('error_products_header') );
			$ok = false;
		}
		if (!$this->validateAdditionalImages( $reader )) {
			$this->log->write( $this->language->get('error_additional_images_header') );
			$ok = false;
		}

		// certain worksheets rely on the existence of other worksheets
		$names = $reader->getSheetNames();
		$exist_products = false;
		$exist_additional_images = false;

		foreach ($names as $name) {
			if ($name=='Products') {
				$exist_products = true;
				continue;
			}
			if ($name=='AdditionalImages') {
				if (!$exist_products) {
					// Missing Products worksheet, or Products worksheet not listed before AdditionalImages
					$this->log->write( $this->language->get('error_additional_images') );
					$ok = false;
				}
				$exist_additional_images = true;
				continue;
			}
		}
		return $ok;
	}


	protected function clearCache() {
		$this->cache->delete('*');
	}


	public function upload( $filename, $incremental=false ) {
		// we use our own error handler
		global $registry;
		$registry = $this->registry;
		set_error_handler('error_handler_for_export_import',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

		try {
			$this->session->data['export_import_nochange'] = 1;

			// we use the PHPExcel package from http://phpexcel.codeplex.com/
			$cwd = getcwd();
			chdir( DIR_SYSTEM.'PHPExcel' );
			require_once( 'Classes/PHPExcel.php' );
			chdir( $cwd );
			
			// Memory Optimization
			if ($this->config->get( 'export_import_settings_use_import_cache' )) {
				$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
				$cacheSettings = array( ' memoryCacheSize '  => '16MB'  );
				PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			}

			// parse uploaded spreadsheet file
			$inputFileType = PHPExcel_IOFactory::identify($filename);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$reader = $objReader->load($filename);

			// read the various worksheets and load them to the database
			if (!$this->validateUpload( $reader )) {
				return false;
			}
			$this->clearCache();
			$this->session->data['export_import_nochange'] = 0;
			$available_product_ids = array();
			$this->uploadCategories( $reader, $incremental );
			$this->uploadProducts( $reader, $incremental, $available_product_ids );
			$this->uploadAdditionalImages( $reader, $incremental, $available_product_ids );
			return true;
		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return false;
		}
	}



	function getStoreIdsForCategories() {
		$sql =  "SELECT category_id, store_id FROM `".DB_PREFIX."category_to_store` cs;";
		$store_ids = array();
		$result = $this->db->query( $sql );
		foreach ($result->rows as $row) {
			$categoryId = $row['category_id'];
			$store_id = $row['store_id'];
			if (!isset($store_ids[$categoryId])) {
				$store_ids[$categoryId] = array();
			}
			if (!in_array($store_id,$store_ids[$categoryId])) {
				$store_ids[$categoryId][] = $store_id;
			}
		}
		return $store_ids;
	}


	protected function setColumnStyles( &$worksheet, &$styles, $min_row, $max_row ) {
		if ($max_row < $min_row) {
			return;
		}
		foreach ($styles as $col=>$style) {
			$from = PHPExcel_Cell::stringFromColumnIndex($col).$min_row;
			$to = PHPExcel_Cell::stringFromColumnIndex($col).$max_row;
			$range = $from.':'.$to;
			$worksheet->getStyle( $range )->applyFromArray( $style, false );
		}
	}


	protected function setCellRow( $worksheet, $row/*1-based*/, $data, &$style=null ) {
		$worksheet->fromArray( $data, null, 'A'.$row, true );
//		foreach ($data as $col=>$val) {
//			$worksheet->setCellValueByColumnAndRow( $col, $row, $val );
//		}
		if (!empty($style)) {
//			$from = 'A'.$row;
//			$to = PHPExcel_Cell::stringFromColumnIndex(count($data)-1).$row;
//			$range = $from.':'.$to;
//			$worksheet->getStyle( $range )->applyFromArray( $style, false );
			$worksheet->getStyle( "$row:$row" )->applyFromArray( $style, false );
		}
	}


	protected function setCell( &$worksheet, $row/*1-based*/, $col/*0-based*/, $val, &$style=null ) {
		$worksheet->setCellValueByColumnAndRow( $col, $row, $val );
		if (!empty($style)) {
			$worksheet->getStyleByColumnAndRow($col,$row)->applyFromArray( $style, false );
		}
	}

	protected function getCategories( $offset=null, $rows=null, $min_id=null, $max_id=null ) {
		$sql  = "SELECT * FROM `".DB_PREFIX."category` ";
		if (isset($min_id) && isset($max_id)) {
			$sql .= "WHERE category_id BETWEEN $min_id AND $max_id ";
		}
		$sql .= "GROUP BY `category_id` ";
		$sql .= "ORDER BY `category_id` ASC ";
		if (isset($offset) && isset($rows)) {
			$sql .= "LIMIT $offset,$rows; ";
		} else {
			$sql .= "; ";
		}
		$results = $this->db->query( $sql );
		return $results->rows;
	}


	protected function populateCategoriesWorksheet( &$worksheet, &$box_format, &$text_format, $offset=null, $rows=null, &$min_id=null, &$max_id=null ) {
		// Set the column widths
		$j = 0;
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('category_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('parent_id')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('top'),5)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('sort_order')+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image_name'),12)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_added'),19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_modified'),19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('description'),32)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('store_ids'),16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('status'),5)+1);
		
		// The heading row and column styles
		$styles = array();
		$data = array();
		$i = 1;
		$j = 0;
		$data[$j++] = 'category_id';
		$data[$j++] = 'parent_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'name';
		$data[$j++] = 'top';
		$data[$j++] = 'sort_order';
		$styles[$j] = &$text_format;
		$data[$j++] = 'image_name';
		$styles[$j] = &$text_format;
		$data[$j++] = 'date_added';
		$styles[$j] = &$text_format;
		$data[$j++] = 'date_modified';
		$styles[$j] = &$text_format;

		$styles[$j] = &$text_format;
		$data[$j++] = 'description';

		$styles[$j] = &$text_format;
		$data[$j++] = 'store_ids';
		$styles[$j] = &$text_format;
		$data[$j++] = 'status';
		$worksheet->getRowDimension($i)->setRowHeight(30);
		$this->setCellRow( $worksheet, $i, $data, $box_format );

		// The actual categories data
		$i += 1;
		$j = 0;
		$store_ids = $this->getStoreIdsForCategories();

		$categories = $this->getCategories( $offset, $rows, $min_id, $max_id );
		$len = count($categories);
		$min_id = $categories[0]['category_id'];
		$max_id = $categories[$len-1]['category_id'];
		foreach ($categories as $row) {
			$worksheet->getRowDimension($i)->setRowHeight(26);
			$data = array();
			$data[$j++] = $row['category_id'];
			$data[$j++] = $row['parent_id'];
			$data[$j++] = html_entity_decode($row['name'],ENT_QUOTES,'UTF-8');
			$data[$j++] = ($row['top']==0) ? "false" : "true";
			$data[$j++] = $row['sort_order'];
			$data[$j++] = $row['image'];
			$data[$j++] = $row['date_added'];
			$data[$j++] = $row['date_modified'];

			$data[$j++] = html_entity_decode($row['description'],ENT_QUOTES,'UTF-8');

			$store_id_list = '';
			$category_id = $row['category_id'];
			if (isset($store_ids[$category_id])) {
				foreach ($store_ids[$category_id] as $store_id) {
					$store_id_list .= ($store_id_list=='') ? $store_id : ','.$store_id;
				}
			}
			$data[$j++] = $store_id_list;

			$data[$j++] = ($row['status']==0) ? 'false' : 'true';
			$this->setCellRow( $worksheet, $i, $data );
			$i += 1;
			$j = 0;
		}
		$this->setColumnStyles( $worksheet, $styles, 2, $i-1 );
	}


	protected function getStoreIdsForProducts() {
		$sql =  "SELECT product_id, store_id FROM `".DB_PREFIX."product_to_store` ps;";
		$store_ids = array();
		$result = $this->db->query( $sql );
		foreach ($result->rows as $row) {
			$productId = $row['product_id'];
			$store_id = $row['store_id'];
			if (!isset($store_ids[$productId])) {
				$store_ids[$productId] = array();
			}
			if (!in_array($store_id,$store_ids[$productId])) {
				$store_ids[$productId][] = $store_id;
			}
		}
		return $store_ids;
	}


	protected function getProductDescriptions( $offset=null, $rows=null, $min_id=null, $max_id=null ) {

		// query the product_description table 
		$sql  = "SELECT p.product_id ";
		$sql .= "FROM `".DB_PREFIX."product` p ";
		$sql .= "LEFT JOIN `".DB_PREFIX."product_description` pd ON pd.product_id=p.product_id ";
		if (isset($min_id) && isset($max_id)) {
			$sql .= "WHERE p.product_id BETWEEN $min_id AND $max_id ";
		}
		$sql .= "GROUP BY p.product_id ";
		$sql .= "ORDER BY p.product_id ";
		if (isset($offset) && isset($rows)) {
			$sql .= "LIMIT $offset,$rows; ";
		} else {
			$sql .= "; ";
		}
		$query = $this->db->query( $sql );
		return $query->rows;
	}


	protected function getProducts( $product_fields, $offset=null, $rows=null, $min_id=null, $max_id=null ) {
		$sql  = "SELECT ";
		$sql .= "  p.product_id,";
		$sql .= "  GROUP_CONCAT( DISTINCT CAST(pc.category_id AS CHAR(11)) SEPARATOR \",\" ) AS categories,";
		$sql .= "  p.location,";
		$sql .= "  p.quantity,";
		$sql .= "  p.model,";
		$sql .= "  m.name AS manufacturer,";
		$sql .= "  p.image AS image_name,";

		$sql .= "  p.price,";
		$sql .= "  p.date_added,";
		$sql .= "  p.date_modified,";
		$sql .= "  p.date_available,";
		$sql .= "  p.status,";
		$sql .= "  p.tax_id,";
		$sql .= "  pd.name,";
		$sql .= "  pd.description,";
		$sql .= "  pd.meta_description,";
		$sql .= "  p.sort_order,";
		$sql .= "  GROUP_CONCAT( DISTINCT CAST(pr.related_id AS CHAR(11)) SEPARATOR \",\" ) AS related ";
		$sql .= "FROM `".DB_PREFIX."product` p ";
		$sql .= "LEFT JOIN `".DB_PREFIX."product_to_category` pc ON p.product_id=pc.product_id ";
		$sql .= "LEFT JOIN `".DB_PREFIX."manufacturer` m ON m.manufacturer_id = p.manufacturer_id ";
		$sql .= "LEFT JOIN `".DB_PREFIX."product_related` pr ON pr.product_id=p.product_id ";
		$sql .= "LEFT JOIN `".DB_PREFIX."product_description` pd ON pd.product_id=p.product_id ";
		if (isset($min_id) && isset($max_id)) {
			$sql .= "WHERE p.product_id BETWEEN $min_id AND $max_id ";
		}
		$sql .= "GROUP BY p.product_id ";
		$sql .= "ORDER BY p.product_id ";
		if (isset($offset) && isset($rows)) {
			$sql .= "LIMIT $offset,$rows; ";
		} else {
			$sql .= "; ";
		}
		$results = $this->db->query( $sql );
		return $results->rows;
	}


	function populateProductsWorksheet( &$worksheet, &$price_format, &$box_format, &$text_format, $offset=null, $rows=null, &$min_id=null, &$max_id=null) {
		// get list of the field names, some are only available for certain OpenCart versions
		$query = $this->db->query( "DESCRIBE `".DB_PREFIX."product`" );
		$product_fields = array();
		foreach ($query->rows as $row) {
			$product_fields[] = $row['Field'];
		}

		$j = 0;
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('product_id'),4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('name')+4,30)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('categories'),12)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('location'),10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('quantity'),4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('model'),8)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('manufacturer'),10)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image_name'),12)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('price'),10)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_added'),19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_modified'),19)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('date_available'),10)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('status'),5)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('tax_id'),2)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('description')+4,32)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('meta_description')+4,32)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('store_ids'),16)+1);

		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('related_ids'),16)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),8)+1);

		// The product headings row and column styles
		$styles = array();
		$data = array();
		$i = 1;
		$j = 0;
		$data[$j++] = 'product_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'name';
		$styles[$j] = &$text_format;
		$data[$j++] = 'categories';

		$styles[$j] = &$text_format;
		$data[$j++] = 'location';
		$data[$j++] = 'quantity';
		$styles[$j] = &$text_format;
		$data[$j++] = 'model';
		$styles[$j] = &$text_format;
		$data[$j++] = 'manufacturer';
		$styles[$j] = &$text_format;
		$data[$j++] = 'image_name';

		$styles[$j] = &$price_format;
		$data[$j++] = 'price';
		$data[$j++] = 'date_added';
		$data[$j++] = 'date_modified';
		$data[$j++] = 'date_available';

		$data[$j++] = 'status';
		$data[$j++] = 'tax_id';
		$styles[$j] = &$text_format;

		$styles[$j] = &$text_format;
		$data[$j++] = 'description';

		$styles[$j] = &$text_format;
		$data[$j++] = 'meta_description';

		$data[$j++] = 'store_ids';
		$styles[$j] = &$text_format;

		$data[$j++] = 'related_ids';
		$data[$j++] = 'sort_order';

		$worksheet->getRowDimension($i)->setRowHeight(30);
		$this->setCellRow( $worksheet, $i, $data, $box_format );

		// The actual products data
		$i += 1;
		$j = 0;
		$store_ids = 0;//$this->getStoreIdsForProducts();

		$products = $this->getProducts( $product_fields, $offset, $rows, $min_id, $max_id );
		$len = count($products);
		$min_id = $products[0]['product_id'];
		$max_id = $products[$len-1]['product_id'];
		foreach ($products as $row) {
			$data = array();
			$worksheet->getRowDimension($i)->setRowHeight(26);
			$product_id = $row['product_id'];
			$data[$j++] = $product_id;
			$data[$j++] = html_entity_decode($row['name'],ENT_QUOTES,'UTF-8');

			$data[$j++] = $row['categories'];

			$data[$j++] = $row['location'];
			$data[$j++] = $row['quantity'];
			$data[$j++] = $row['model'];
			$data[$j++] = $row['manufacturer'];
			$data[$j++] = $row['image_name'];

			$data[$j++] = $row['price'];

			$data[$j++] = $row['date_added'];
			$data[$j++] = $row['date_modified'];
			$data[$j++] = $row['date_available'];

			$data[$j++] = ($row['status']==0) ? 'false' : 'true';
			$data[$j++] = $row['tax_id'];

			$data[$j++] = html_entity_decode($row['description'],ENT_QUOTES,'UTF-8');
			$data[$j++] = html_entity_decode($row['meta_description'],ENT_QUOTES,'UTF-8');

			$store_id_list = '';
			if (isset($store_ids[$product_id])) {
				foreach ($store_ids[$product_id] as $store_id) {
					$store_id_list .= ($store_id_list=='') ? $store_id : ','.$store_id;
				}
			}
			$data[$j++] = $store_id_list;

			$data[$j++] = $row['related'];
			$data[$j++] = $row['sort_order'];

			$this->setCellRow( $worksheet, $i, $data );
			$i += 1;
			$j = 0;
		}
		$this->setColumnStyles( $worksheet, $styles, 2, $i-1 );
	}


	protected function getAdditionalImages( $min_id=null, $max_id=null, $exist_sort_order=true  ) {
		if ($exist_sort_order) {
			$sql  = "SELECT product_id, image, sort_order ";
		} else {
			$sql  = "SELECT product_id, image ";
		}
		$sql .= "FROM `".DB_PREFIX."product_image` ";
		if (isset($min_id) && isset($max_id)) {
			$sql .= "WHERE product_id BETWEEN $min_id AND $max_id ";
		}
		if ($exist_sort_order) {
			$sql .= "ORDER BY product_id, sort_order, image;";
		} else {
			$sql .= "ORDER BY product_id, image;";
		}
		$result = $this->db->query( $sql );
		return $result->rows;
	}


	protected function populateAdditionalImagesWorksheet( &$worksheet, &$box_format, &$text_format, $min_id=null, $max_id=null) {
		// check for the existence of product_image.sort_order field
		$sql = "SHOW COLUMNS FROM `".DB_PREFIX."product_image` LIKE 'sort_order'";
		$query = $this->db->query( $sql );
		$exist_sort_order = ($query->num_rows > 0) ? true : false;

		// Set the column widths
		$j = 0;
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('product_id'),4)+1);
		$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('image'),30)+1);
		if ($exist_sort_order) {
			$worksheet->getColumnDimensionByColumn($j++)->setWidth(max(strlen('sort_order'),5)+1);
		}

		// The additional images headings row and colum styles
		$styles = array();
		$data = array();
		$i = 1;
		$j = 0;
		$data[$j++] = 'product_id';
		$styles[$j] = &$text_format;
		$data[$j++] = 'image';
		if ($exist_sort_order) {
			$data[$j++] = 'sort_order';
		}
		$worksheet->getRowDimension($i)->setRowHeight(30);
		$this->setCellRow( $worksheet, $i, $data, $box_format );

		// The actual additional images data
		$styles = array();
		$i += 1;
		$j = 0;
		$additional_images = $this->getAdditionalImages( $min_id, $max_id, $exist_sort_order );
		foreach ($additional_images as $row) {
			$data = array();
			$worksheet->getRowDimension($i)->setRowHeight(13);
			$data[$j++] = $row['product_id'];
			$data[$j++] = $row['image'];
			if ($exist_sort_order) {
				$data[$j++] = $row['sort_order'];
			}
			$this->setCellRow( $worksheet, $i, $data );
			$i += 1;
			$j = 0;
		}
		$this->setColumnStyles( $worksheet, $styles, 2, $i-1 );
	}

	protected function clearSpreadsheetCache() {
		$files = glob(DIR_CACHE . 'Spreadsheet_Excel_Writer' . '*');
		
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					@unlink($file);
					clearstatcache();
				}
			}
		}
	}
   

	public function getMaxProductId() {
		$query = $this->db->query( "SELECT MAX(product_id) as max_product_id FROM `".DB_PREFIX."product`" );
		if (isset($query->row['max_product_id'])) {
			$max_id = $query->row['max_product_id'];
		} else {
			$max_id = 0;
		}
		return $max_id;
	}


	public function getMinProductId() {
		$query = $this->db->query( "SELECT MIN(product_id) as min_product_id FROM `".DB_PREFIX."product`" );
		if (isset($query->row['min_product_id'])) {
			$min_id = $query->row['min_product_id'];
		} else {
			$min_id = 0;
		}
		return $min_id;
	}


	public function getCountProduct() {
		$query = $this->db->query( "SELECT COUNT(product_id) as count_product FROM `".DB_PREFIX."product`" );
		if (isset($query->row['count_product'])) {
			$count = $query->row['count_product'];
		} else {
			$count = 0;
		}
		return $count;
	}  

 
	public function getMaxCategoryId() {
		$query = $this->db->query( "SELECT MAX(category_id) as max_category_id FROM `".DB_PREFIX."category`" );
		if (isset($query->row['max_category_id'])) {
			$max_id = $query->row['max_category_id'];
		} else {
			$max_id = 0;
		}
		return $max_id;
	}


	public function getMinCategoryId() {
		$query = $this->db->query( "SELECT MIN(category_id) as min_category_id FROM `".DB_PREFIX."category`" );
		if (isset($query->row['min_category_id'])) {
			$min_id = $query->row['min_category_id'];
		} else {
			$min_id = 0;
		}
		return $min_id;
	}


	public function getCountCategory() {
		$query = $this->db->query( "SELECT COUNT(category_id) as count_category FROM `".DB_PREFIX."category`" );
		if (isset($query->row['count_category'])) {
			$count = $query->row['count_category'];
		} else {
			$count = 0;
		}
		return $count;
	}  

 
	public function download( $export_type, $offset=null, $rows=null, $min_id=null, $max_id=null) {
		// we use our own error handler
		global $registry;
		$registry = $this->registry;
		set_error_handler('error_handler_for_export_import',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

		// Use the PHPExcel package from http://phpexcel.codeplex.com/
		$cwd = getcwd();
		chdir( DIR_SYSTEM.'PHPExcel' );
		require_once( 'Classes/PHPExcel.php' );
		chdir( $cwd );

		// find out whether all data is to be downloaded
		$all = !isset($offset) && !isset($rows) && !isset($min_id) && !isset($max_id);

		// Memory Optimization
		if ($this->config->get( 'export_import_settings_use_export_cache' )) {
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cacheSettings = array( 'memoryCacheSize'  => '16MB' );  
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);  
		}

		try {
			// set appropriate timeout limit
			set_time_limit( 1800 );
			// create a new workbook
			$workbook = new PHPExcel();

			// set some default styles
			$workbook->getDefaultStyle()->getFont()->setName('Arial');
			$workbook->getDefaultStyle()->getFont()->setSize(10);
			//$workbook->getDefaultStyle()->getAlignment()->setIndent(0.5);
			$workbook->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$workbook->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$workbook->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

			// pre-define some commonly used styles
			$box_format = array(
				'fill' => array(
					'type'      => PHPExcel_Style_Fill::FILL_SOLID,
					'color'     => array( 'rgb' => 'F0F0F0')
				),
				/*
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
				*/
			);
			$text_format = array(
				/*
				'numberformat' => array(
					'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
				*/
			);
			$price_format = array(
				'numberformat' => array(
					'code' => '######0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					/*
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
					*/
				)
			);
			$weight_format = array(
				'numberformat' => array(
					'code' => '##0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					/*
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
					*/
				)
			);
			
			// create the worksheets
			$worksheet_index = 0;
			switch ($export_type) {
				case 'c':
					// creating the Categories worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Categories' );
					$this->populateCategoriesWorksheet( $worksheet, $box_format, $text_format, $offset, $rows, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );
					break;

				case 'p':
					// creating the Products worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Products' );
					$this->populateProductsWorksheet( $worksheet, $price_format, $box_format, $weight_format, $text_format, $offset, $rows, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the AdditionalImages worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'AdditionalImages' );
					$this->populateAdditionalImagesWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

				default:
					break;
			}

			$workbook->setActiveSheetIndex(0);

			// redirect output to client browser
			$datetime = date('Y-m-d');
			switch ($export_type) {
				case 'c':
					$filename = 'categories-'.$datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-$offset";
						} else if (isset($min_id)) {
							$filename .= "-start-$min_id";
						}
						if (isset($rows)) {
							$filename .= "-rows-$rows";
						} else if (isset($max_id)) {
							$filename .= "-end-$max_id";
						}
					}
					$filename .= '.xlsx';
					break;
				case 'p':
					$filename = 'products-'.$datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-$offset";
						} else if (isset($min_id)) {
							$filename .= "-start-$min_id";
						}
						if (isset($rows)) {
							$filename .= "-rows-$rows";
						} else if (isset($max_id)) {
							$filename .= "-end-$max_id";
						}
					}
					$filename .= '.xlsx';
					break;
				default:
					$filename = $datetime.'.xlsx';
					break;
			}
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
			$objWriter->setPreCalculateFormulas(false);
			$objWriter->save('php://output');

			// Clear the spreadsheet caches
			$this->clearSpreadsheetCache();
			exit;

		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
			return;
		}
	}


	protected function curl_get_contents($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}


	public function getNotifications() {
		$result = '';
		return $result;
	}

}
?>