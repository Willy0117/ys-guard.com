<?php
class ModelSaleCustomerGroup extends Model {
	public function addCustomerGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) 
		. "', base = '" . $this->db->escape($data['base'])
		. "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");
	}

	public function editCustomerGroup($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) 
		. "', base = '" . $this->db->escape($data['base'])				 
		. "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
	}

	public function deleteCustomerGroup($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE id = '" . (int)$id . "'");
	}

	public function getCustomerGroup($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getCustomerGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_group WHERE 1 ";

		$sort_data = array(
			'id',
			'name',
			'code',
			'base',
			'sort_order',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY id";
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

	public function getTotalCustomerGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_group");

		return $query->row['total'];
	}
	
	public function getBaseGroups() {
		$sql = "SELECT * FROM " . DB_PREFIX . "base_code WHERE 1 ";

		$query = $this->db->query($sql);

		return $query->rows;
	}
}