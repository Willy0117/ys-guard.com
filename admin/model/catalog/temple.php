<?php
class ModelCatalogTemple extends Model {
	public function addTemple($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "temple SET sect_id = '" . (int)$data['sect_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$id = $this->db->getLastId();

		return $id;
	}

	public function editTemple($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "temple SET sect_id = '" . (int)$data['sect_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
	}

	public function deleteTemple($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "temple WHERE id = '" . (int)$id . "'");
	}

	public function getTemple($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "temple WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getTemples($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "temple WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_sect_id'])) {
			$sql .= " AND sect_id = '" . $this->db->escape($data['filter_sect_id']) . "'";
		}

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
	}

	public function getTotalTemples() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "temple");

		return $query->row['total'];
	}
}