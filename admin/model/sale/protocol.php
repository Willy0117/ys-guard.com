<?php
class ModelSaleProtocol extends Model {
	public function addProtocol($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "protocol SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$protocol_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "protocol SET image = '" . $this->db->escape($data['image']) . "' WHERE protocol_id = '" . (int)$protocol_id . "'");
		}

		$this->cache->delete('protocol');

		return $protocol_id;
	}

	public function editProtocol($protocol_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "protocol SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE protocol_id = '" . (int)$protocol_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "protocol SET image = '" . $this->db->escape($data['image']) . "' WHERE protocol_id = '" . (int)$protocol_id . "'");
		}
	}

	public function deleteProtocol($protocol_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "protocol WHERE protocol_id = '" . (int)$protocol_id . "'");
	}

	public function getProtocol($protocol_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "protocol WHERE protocol_id = '" . (int)$protocol_id . "'");

		return $query->row;
	}

	public function getProtocols($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "protocol";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
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
	}

	public function getTotalProtocols() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "protocol");

		return $query->row['total'];
	}
}