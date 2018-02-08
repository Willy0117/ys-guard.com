<?php
class ModelLocalisationTax extends Model {
	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "tax SET title = '" . $this->db->escape($data['title']) . "', rate = '" . (float)$data['rate'] . "', date_added = NOW()");

		$this->cache->delete('tax');
	}

	public function edit($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "tax SET title = '" . $this->db->escape($data['title']) . "', rate = '" . (float)$data['rate'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");

		$this->cache->delete('tax');
	}

	public function delete($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tax WHERE id = '" . (int)$id . "'");

		$this->cache->delete('tax');
	}

	public function getTax($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getTaxes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tax";

		$sort_data = array(
			'title',
			'rate'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY title";
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

	public function getTotalTaxes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tax");

		return $query->row['total'];
	}
}