<?php
class ModelCatalogSect extends Model {
	public function addSect($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "sect SET sort_order = '" . (int)$this->request->post['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$id = $this->db->getLastId(); 
			
		$this->cache->delete('sect');
	}
	
	public function editSect($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "sect SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
		
		$this->cache->delete('sect');
	}
	
	public function deleteSect($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sect WHERE id = '" . (int)$id . "'");

		$this->cache->delete('sect');
	}	

	public function getSect($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "sect WHERE id = '" . (int)$id . "'");
		
		return $query->row;
	}
		
	public function getSects($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "sect WHERE 1 ";
		
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
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sect WHERE 1 ORDER BY name");
	
			return $query->rows;
		}
	}

	public function getTotalSects() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sect");
		
		return $query->row['total'];
	}	
}
?>