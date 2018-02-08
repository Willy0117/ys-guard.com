<?php
class ModelToolRestore extends Model {
	public function addrestore() {
	}
	public function deleterestore($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "bc_estimate_head WHERE estimate_id = '" . (int)$id . "'");
	} 

	public function getrestore( $id ) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "bc_estimate_head WHERE estimate_id = '" . (int)$id . "'");
		
		return $query->row;
	} 
	
	public function getrestores() {
		$hall_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bc_estimate_head");
		
		return $query->rows;
	}
	
	public function getTotalrestore() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bc_estimate_head");
		
		return $query->row['total'];
	}	
}
?>