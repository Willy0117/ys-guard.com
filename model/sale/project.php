<?php
class ModelSaleProject extends Model {
	public function addProject($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "project SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$project_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "project SET image = '" . $this->db->escape($data['image']) . "' WHERE project_id = '" . (int)$project_id . "'");
		}

		$this->cache->delete('project');

		return $project_id;
	}

	public function editProject($project_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "project SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE project_id = '" . (int)$project_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "project SET image = '" . $this->db->escape($data['image']) . "' WHERE project_id = '" . (int)$project_id . "'");
		}
	}

	public function deleteProject($project_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$project_id . "'");
	}

	public function getProject($project_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$project_id . "'");

		return $query->row;
	}

	public function getProjects($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "project";

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

	public function getTotalProjects() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "project");

		return $query->row['total'];
	}
}