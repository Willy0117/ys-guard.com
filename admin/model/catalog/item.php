<?php
class ModelCatalogItem extends Model {
	public function addItem($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "item SET sort_order = '" . (int)$this->request->post['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$item_id = $this->db->getLastId(); 
	}
	
	public function editItem($item_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "item SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE item_id = '" . (int)$item_id . "'");
	}
	
	public function deleteItem($item_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "item WHERE item_id = '" . (int)$item_id . "'");
	}	

	public function getItem($item_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "item WHERE item_id = '" . (int)$item_id . "'");
		
		return $query->row;
	}
		
	public function getItems($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "item WHERE 1 ";
		
			$sort_data = array(
				'name',
				'sort_order',
				'status'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY name";	
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
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE 1 ORDER BY name");
	
			$item_data = $query->rows;
			
			return $item_data;			
		}
	}

	public function getTotalItems() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "item");
		
		return $query->row['total'];
	}	
}
?>