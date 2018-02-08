<?php
class ModelCatalogVehicle extends Model {

	public function addVehicle($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "vehicle SET name = '" . $this->db->escape($data['name']) 
		. "', date_modified = NOW(), date_added = NOW()");

		$this->cache->delete('vehicle');
	}

	public function editVehicle($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "vehicle SET name = '" . $this->db->escape($data['name']) 
		. "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
	}

	public function deleteVehicle($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "vehicle WHERE id = '" . (int)$id . "'");
	}

	public function getVehicle($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "vehicle WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getVehicles($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vehicle";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
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

	public function getTotalVehicles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vehicle");

		return $query->row['total'];
	}
}