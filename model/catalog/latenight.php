<?php
class ModelCatalogLatenight extends Model {
	public function addLatenight($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "latenight SET timeindex = '" . $this->db->escape($data['timeindex']) . "', price = '" . $data['price'] . "', invoice = '" . $data['invoice'] . "', tax_id = '" . (int)$data['tax_id']. "', date_modified = NOW(), date_added = NOW()");

		$id = $this->db->getLastId(); 
			
		$this->cache->delete('latenight');
	}
	
	public function editLatenight($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "latenight SET timeindex = '" . $this->db->escape($data['timeindex']) . "', price = '" . $data['price'] . "', invoice = '" . $data['invoice'] . "', tax_id = '" . (int)$data['tax_id'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
		
		$this->cache->delete('latenight');
	}
	
	public function deleteLatenight($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "latenight WHERE id = '" . (int)$id . "'");

		$this->cache->delete('latenight');
	}	

	public function getLatenight($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "latenight WHERE id = '" . (int)$id . "'");
		
		return $query->row;
	}
		
	public function getLatenights($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "latenight WHERE 1 ";
		
		$sort_data = array(
			'timeindex',
			'price',
			'invoice'
		);		
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY timeindex";	
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

	public function getTotalLatenights() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "latenight");
		
		return $query->row['total'];
	}
	
	public function getLatenightByPrice($minute) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "latenight WHERE timeindex = '" . (int)$minute . "'");
		
		return $query->row;		
		
	}
}
?>