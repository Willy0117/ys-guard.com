<?php
class ModelCatalogTransport extends Model {
	public function addtransport($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "transport SET distance = '" . (int)$data['distance']  
		. "', price = '" . $data['price'] . "', invoice = '" . $data['invoice']
        . "', date_from = '" . $data['date_from'] . "', date_to = '" . $data['date_to']                     
		. "', date_modified = NOW(), date_added = NOW()");

	}

	public function editTransport($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "transport SET distance = '" . (int)$data['distance'] 
		. "', price = '" . (int)$data['price'] . "', invoice = '" . $data['invoice'] 
        . "', date_from = '" . $data['date_from'] . "', date_to = '" . $data['date_to']                 
		. "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
	}

	public function deleteTransport($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "transport WHERE id = '" . (int)$id . "'");
	}

	public function getTransport($id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "transport WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getTransports($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "transport WHERE 1 ";

		if (!empty($data['filter_price'])) {
			$sql .= " AND price = '" . $this->db->escape($data['filter_price']) . "'";
		}

		if (!empty($data['filter_invoice'])) {
			$sql .= " AND invoice = '" . $this->db->escape($data['filter_price']) . "'";
		}

		if (!empty($data['filter_distance'])) {
			$sql .= " AND distance = '" . $this->db->escape($data['filter_distance']) . "'";
		}

		$sort_data = array(
			'distance',
			'price',
			'invoice',
            'date_from',
            'date_to',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY distance";
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

	public function getTotalTransports() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "transport");

		return $query->row['total'];
	}

	public function getMileage($distance,$travel) {
		$sql = "SELECT * FROM " . DB_PREFIX . "transport WHERE distance >= '". $distance . "'";

        if (isset($travel) && $travel !== null) {
			$sql .= " AND CAST('" . $travel . "' AS DATE) BETWEEN date_from AND date_to ";
		}
        
		$sql .= " ORDER BY distance";
		$query = $this->db->query($sql);
		return $query->rows;
	}
}