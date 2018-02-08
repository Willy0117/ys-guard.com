<?php
class ModelCatalogReligious extends Model {
	public function addReligious($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "religious SET sort_order = '" . (int)$this->request->post['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$religious_id = $this->db->getLastId(); 
			
		$this->cache->delete('religious');
	}
	
	public function editReligious($religious_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "religious SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE religious_id = '" . (int)$religious_id . "'");
		
		$this->cache->delete('religious');
	}
	
	public function deleteReligious($religious_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "religious WHERE religious_id = '" . (int)$religious_id . "'");

		$this->cache->delete('religious');
	}	

	public function getReligious($religious_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "religious WHERE religious_id = '" . (int)$religious_id . "'");
		
		return $query->row;
	}
		
	public function getReligiouss($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "religious WHERE 1 ";
		
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
			$religious_data = $this->cache->get('religious.' . $this->config->get('config_language_id'));
		
			if (!$religious_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "religious WHERE 1 ORDER BY name");
	
				$religious_data = $query->rows;
			
				$this->cache->set('religious.' . $this->config->get('config_language_id'), $religious_data);
			}	
	
			return $religious_data;			
		}
	}

	public function getTotalReligiouss() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "religious");
		
		return $query->row['total'];
	}	
}
?>