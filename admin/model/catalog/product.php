<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) 
		. "', name = '" . $this->db->escape($data['name'])  				 
		. "', customer_group = '" . (int)$data['customer_group'] . "', quantity = '" . (int)$data['quantity'] 
		. "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$id = $this->db->getLastId();

		if (isset($data['category_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET id = '" . (int)$id . "', category_id = '" . (int)$data['category_id'] . "'");
		} 
		// 価格テーブルから一旦、商品idが同じ価格を削除
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$id . "'");

		if (isset($data['price'])) {
			$i=0;	
			while ($i < count($data['price']) ) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_price SET product_id = '" . (int)$id 
				. "', price = '" . $data['price'][$i] . "', invoice = '" . $data['invoice'][$i] 
				. "', tax_id = '" . (int)$data['tax_id'][$i] 
				. "', date_from = '" . $data['date_from'][$i] 
				. "', date_to = '" . $data['date_to'][$i] 
				. "', date_added = NOW(), date_modified = NOW()");			 
				$i++;
			}
		}

		$this->cache->delete('product');

		return $id;
	}

	public function editProduct($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) 
		. "', name = '" . $this->db->escape($data['name'])				 
		. "', customer_group = '" . (int)$data['customer_group']. "', quantity = '" . (int)$data['quantity'] 
		. "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE id = '" . (int)$id . "'");

		if (isset($data['category_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET id = '" . (int)$id . "', category_id = '" . (int)$data['category_id'] . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$id . "'");
		if (isset($data['price'])) {
			$i=0;	
			while ($i < count($data['price']) ) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_price SET product_id = '" . (int)$id 
				. "', price = '" . $data['price'][$i] . "', invoice = '" . $data['invoice'][$i] 
				. "', tax_id = '" . (int)$data['tax_id'][$i] 
				. "', date_from = '" . $data['date_from'][$i] 
				. "', date_to = '" . $data['date_to'][$i] 
				. "', date_added = NOW(), date_modified = NOW()");			 
				$i++;
			}
		}

		$this->cache->delete('product');
	}

	public function copyProduct($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product WHERE id = '" . (int)$id  . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['viewed'] = '0';
			$data['status'] = '0';

			$data['category_id'] = $this->getProductCategories($id);
			$data['price'] = $this->getProductPrices($id);
			var_dump($data['price']);
//stop();
			$this->addProduct($data);
		}
	}

	public function deleteProduct($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE id = '" . (int)$id . "'");
		$this->cache->delete('product');
	}

	public function getProduct($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.id = pc.id)  WHERE p.id = '" . (int)$id  . "'");

		return $query->row;
	}

	public function getProducts($data = array()) {
         $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.id = pc.id) LEFT JOIN " . DB_PREFIX . "product_price pp ON (p.id = pp.product_id) WHERE 1 ";
		
        if (isset($data['filter_date']) && $data['filter_date'] !== null) {
			$sql .= " AND pp.date_from <= CAST('" . $data['filter_date'] . "' AS DATE) AND CAST('" . $data['filter_date'] . "'AS DATE) <= pp.date_to ";
			$sql .= " AND CAST('" . $data['filter_date'] . "' AS DATE) BETWEEN pp.date_from AND pp.date_to ";
		}
        if (isset($data['filter_customer_group']) && $data['filter_customer_group'] !== null) {
         	$sql .= " AND p.customer_group = '" . (int)$data['filter_customer_group'] . "'";
        }
						
		if (!empty($data['filter_name'])) {
			$sql .= " AND p.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

        if (isset($data['filter_category']) && $data['filter_category'] !== null) {
         	$sql .= " AND pc.category_id = '" . (int)$data['filter_category'] . "'";
        }
						
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.id";

		$sort_data = array(
			'p.name',
			'pc.category_id',
			'p.customer_group',
			'p.model',
			'pp.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.id = p2c.id) WHERE 1 AND p2c.category_id = '" . (int)$category_id . "' ORDER BY p.name ASC");

		return $query->rows;
	}

	public function getProductCategories($id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE id = '" . (int)$id . "'");

		foreach ($query->rows as $result) {
			$product_category_data = $result['category_id'];
		}

		return $product_category_data;
	}
	
	
	public function getProductPrices($id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$id . "' order by price_id ASC");
		//print_r($query);
		$product_price_data= array();
		
		foreach ($query->rows as $result) {
			$product_price_data[] = array(
				'price' => $result['price'],
				'invoice' => $result['invoice'],
				'tax_id' => $result['tax_id'],
				'date_from' => $result['date_from'],
				'date_to' => $result['date_to'],
			);
		}
		return $product_price_data;
	}

	public function getTotalProducts($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.id = pc.id) WHERE  1 ";		
				
        if (isset($data['filter_customer_group']) && $data['filter_customer_group'] !== null) {
         	$sql .= " AND p.customer_group = '" . (int)$data['filter_customer_group'] . "'";
        }

		if (!empty($data['filter_name'])) {
			$sql .= " AND p.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

         if (isset($data['filter_category']) && $data['filter_category'] !== null) {
         	$sql .= " AND pc.category_id = '" . (int)$data['filter_category'] . "'";
         }
		 
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProductByTravel($id,$travel) {
         $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_price pp ON (p.id = pp.product_id) WHERE  id = '" . (int)$id . "'";
		
        if (isset($travel) && $travel !== null) {
			//$sql .= " AND pp.date_from <= CAST('" . $travel . "' AS DATE) AND CAST('" . $travel . "'AS DATE) <= pp.date_to ";
			$sql .= " AND CAST('" . $travel . "' AS DATE) BETWEEN pp.date_from AND pp.date_to ";
		}

		$sql .= " GROUP BY p.id";
		$sql .= " ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	
	public function mgetProducts($data = array()) {
         $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.id = pc.id) LEFT JOIN " . DB_PREFIX . "product_price pp ON (p.id = pp.product_id) WHERE 1 ";
		
        if (isset($data['filter_date']) && $data['filter_date'] !== null) {
			//$sql .= " AND pp.date_from <= CAST('" . $data['filter_date'] . "' AS DATE) AND CAST('" . $data['filter_date'] . "'AS DATE) <= pp.date_to ";
			$sql .= " AND CAST('" . $data['filter_date'] . "' AS DATE) BETWEEN pp.date_from AND pp.date_to ";
		}
        if (isset($data['filter_customer_group']) && $data['filter_customer_group'] !== null) {
         	$sql .= " AND ( p.customer_group = 0 || p.customer_group = '" . (int)$data['filter_customer_group'] . "' )";
        }
						
		if (!empty($data['filter_name'])) {
			$sql .= " AND p.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

        if (isset($data['filter_category']) && $data['filter_category'] !== null) {
         	$sql .= " AND pc.category_id = '" . (int)$data['filter_category'] . "'";
        }
						
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.id";

		$sort_data = array(
			'p.name',
			'pc.category_id',
			'p.customer_group',
			'p.model',
			'pp.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	

	public function mgetTotalProducts($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.id = pc.id)  LEFT JOIN " . DB_PREFIX . "product_price pp ON (p.id = pp.product_id) WHERE 1 ";		
				
        if (isset($data['filter_date']) && $data['filter_date'] !== null) {
			//$sql .= " AND pp.date_from <= CAST('" . $data['filter_date'] . "' AS DATE) AND CAST('" . $data['filter_date'] . "'AS DATE) <= pp.date_to ";
			$sql .= " AND CAST('" . $data['filter_date'] . "' AS DATE) BETWEEN pp.date_from AND pp.date_to ";
		}
				
        if (isset($data['filter_customer_group']) && $data['filter_customer_group'] !== null) {
         	$sql .= " AND ( p.customer_group = 0 || p.customer_group = '" . (int)$data['filter_customer_group'] . "' )";
        }

		if (!empty($data['filter_name'])) {
			$sql .= " AND p.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

         if (isset($data['filter_category']) && $data['filter_category'] !== null) {
         	$sql .= " AND pc.category_id = '" . (int)$data['filter_category'] . "'";
         }
		 
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}	
}