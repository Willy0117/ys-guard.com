<?php
class ModelSaleCustomer extends Model {
	public function addCustomer($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$data['customer_group_id'] 
		. "', project_id = '" . (int)$data['project_id'] 
		. "', protocol_id = '" . $this->db->escape($data['protocol_id']) 
		. "', firstname = '" . $this->db->escape($data['firstname']) 
		. "', lastname = '" . $this->db->escape($data['lastname']) 
		. "', email = '" . $this->db->escape($data['email']) 
		. "', telephone = '" . $this->db->escape($data['telephone']) 
		. "', fax = '" . $this->db->escape($data['fax']) 
		. "', company = '" . $this->db->escape($data['company']) 
		. "', postcode = '" . $this->db->escape($data['postcode']) 
		. "', pref = '" . $this->db->escape($data['pref']) 
		. "', city = '" . $this->db->escape($data['city'])
		. "', address_1 = '" . $this->db->escape($data['address_1'])
		. "', address_2 = '" . $this->db->escape($data['address_2']) 
		. "', comment = '" . $this->db->escape($data['comment'])
		. "', design = '" . $this->db->escape($data['design'])
		. "', ip = '" . $this->db->escape($data['ip'])
		. "', status = '" . (int)$data['status'] 
	    . "', date_added = NOW()");

		$customer_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET image = '" . $this->db->escape($data['image']) . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}

	}

	public function editCustomer($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$data['customer_group_id'] 
		. "', project_id = '" . (int)$data['project_id'] 
		. "', protocol_id = '" . $this->db->escape($data['protocol_id']) 
		. "', firstname = '" . $this->db->escape($data['firstname']) 
		. "', lastname = '" . $this->db->escape($data['lastname']) 
		. "', email = '" . $this->db->escape($data['email']) 
		. "', telephone = '" . $this->db->escape($data['telephone']) 
		. "', fax = '" . $this->db->escape($data['fax']) 
		. "', company = '" . $this->db->escape($data['company']) 
		. "', postcode = '" . $this->db->escape($data['postcode']) 
		. "', pref = '" . $this->db->escape($data['pref'])
		. "', city = '" . $this->db->escape($data['city'])
		. "', address_1 = '" . $this->db->escape($data['address_1'])
		. "', address_2 = '" . $this->db->escape($data['address_2']) 
		. "', comment = '" . $this->db->escape($data['comment']) 
		. "', design = '" . $this->db->escape($data['design'])
		. "', ip = '" . $this->db->escape($data['ip'])
		. "', status = '" . (int)$data['status'] 
		. "' WHERE customer_id = '" . (int)$customer_id . "'");
		
				
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET image = '" . $this->db->escape($data['image']) . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}

	}

	public function editToken($customer_id, $token) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = '" . $this->db->escape($token) . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function deleteCustomer($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getCustomers($data = array()) {
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "customer WHERE 1 ";

		$implode = array();

		if (!empty($data['filter_project_id'])) {
			$implode[] = "project_id = '" . (int)$data['filter_project_id'] . "'";
		}
		
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_company'])) {
			$implode[] = "company LIKE '%" . $this->db->escape($data['filter_company']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'project_id',
			'name',
			'email',
			'telphone',
			'customer_group_id',
			'status',
			'company',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY CONCAT(firstname, ' ', lastname) ";
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

	public function getTotalCustomers($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";

		$implode = array();

		if (!empty($data['filter_project_id'])) {
			$implode[] = "project_id = '" . (int)$data['filter_project_id'] . "'";
		}
		
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
		}

		if (!empty($data['filter_company'])) {
			$implode[] = "company LIKE '%" . $this->db->escape($data['filter_company']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
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

	public function getTotalCustomersByCustomerGroupId($customer_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int)$customer_group_id . "'");

		return $query->row['total'];
	}
	
	public function getPrefs() {
		$query = $this->db->query("SELECT pref FROM " . DB_PREFIX . "pref");

		return $query->rows;

	}
}