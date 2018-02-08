<?php
class ModelSaleCheck extends Model {
	public function addCheck($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "checker SET name = '" . $this->db->escape($data['name']) 
		. "', number = '" . (int)$data['number']
		. "', project_id = '" . (int)$data['project_id']
		. "', customer_group_id = '" . (int)$data['customer_group_id']
		. "', deceased = '" . (int)$data['deceased']
		. "', relation = '" . (int)$data['relation']
		. "', mourner = '" . (int)$data['mourner']
		. "', mourner1 = '" . (int)$data['mourner1']
		. "', mourner2 = '" . (int)$data['mourner2']
		. "', mourner3 = '" . (int)$data['mourner3']
		. "', address = '" . (int)$data['address']
		. "', death = '" . (int)$data['death']
		. "', days = '" . (int)$data['days']
		. "', crest = '" . (int)$data['crest']
		. "', design = '" . (int)$data['design']
		. "', sentence = '" . (int)$data['sentence']
		. "', customer = '" . $this->db->escape($data['customer'])
		. "', protocol_id = '" . (int)$data['protocol_id']
	    . "', date_added = NOW()");
	}

	public function editCheck($check_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "checker SET name = '" . $this->db->escape($data['name']) 
		. "', number = '" . (int)$data['number']
		. "', project_id = '" . (int)$data['project_id']
		. "', customer_group_id = '" . (int)$data['customer_group_id']
		. "', deceased = '" . (int)$data['deceased']
		. "', relation = '" . (int)$data['relation']
		. "', mourner = '" . (int)$data['mourner']
		. "', mourner1 = '" . (int)$data['mourner1']
		. "', mourner2 = '" . (int)$data['mourner2']
		. "', mourner3 = '" . (int)$data['mourner3']
		. "', address = '" . (int)$data['address']
		. "', death = '" . (int)$data['death']
		. "', days = '" . (int)$data['days']
		. "', crest = '" . (int)$data['crest']
		. "', design = '" . (int)$data['design']
		. "', sentence = '" . (int)$data['sentence']
		. "', customer = '" . $this->db->escape($data['customer'])
		. "', protocol_id = '" . (int)$data['protocol_id']
		. "' WHERE check_id = '" . (int)$check_id . "'");
	}

	public function deleteCheck($check_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "checker WHERE check_id = '" . (int)$check_id . "'");
	}

	public function getCheck($check_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "checker WHERE check_id = '" . (int)$check_id . "'");

		return $query->row;
	}

	public function getChecks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "checker WHERE 1 ";

		$implode = array();

		if (!empty($data['filter_project_id'])) {
			$implode[] = "project_id = '" . (int)$data['filter_project_id'] . "'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}
		
		if (!empty($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_customer'])) {
			$implode[] = "customer LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}
		
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'name',
			'project_id',
			'customer_group_id',
			'customer',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name ";
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

	public function getTotalChecks($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "checker";

		$implode = array();

		if (!empty($data['filter_project_id'])) {
			$implode[] = "project_id = '" . (int)$data['filter_project_id'] . "'";
		}
		
		if (!empty($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}		

		if (!empty($data['filter_customer'])) {
			$implode[] = "customer LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalChecksByCheckGroupId($customer_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "checker WHERE customer_group_id = '" . (int)$customer_group_id . "'");

		return $query->row['total'];
	}
}