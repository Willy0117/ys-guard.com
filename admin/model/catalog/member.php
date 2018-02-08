<?php
class ModelCatalogMember extends Model {
	public function addMember($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "member SET sort_order = '" . (int)$this->request->post['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$member_id = $this->db->getLastId(); 
			
		$this->cache->delete('member');

	}
	
	public function editMember($member_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "member SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "' WHERE member_id = '" . (int)$member_id . "'");
		
		$this->cache->delete('member');
	}
	
	public function deleteMember($member_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "member WHERE member_id = '" . (int)$member_id . "'");

		$this->cache->delete('member');
	}	

	public function getMember($member_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "member WHERE member_id = '" . (int)$member_id . "'");
		
		return $query->row;
	}
		
	public function getMembers($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "member WHERE 1 ";
		
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
			$member_data = $this->cache->get('member.' . $this->config->get('config_language_id'));
		
			if (!$member_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "member WHERE 1 ORDER BY name");
	
				$member_data = $query->rows;
			
				$this->cache->set('member.' . $this->config->get('config_language_id'), $member_data);
			}	
	
			return $member_data;			
		}
	}

	public function getTotalMembers() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "member");
		
		return $query->row['total'];
	}	
}
?>