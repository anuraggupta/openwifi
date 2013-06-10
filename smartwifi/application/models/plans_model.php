<?php
Class Plans_model extends CI_Model {
		
	function getPlan() {
		$query = $this->db->get('plans');
		return $query->result();
	}
 
	function addPlan($data) {
		$this->db->insert('plans', $data);
		return;
	}
	
	function updatePlan($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('plans', $data);
	}
	
	function deletePlan(){
		$this->db->where('id', $this->uri->segment(3));
		$this->db->delete('plans');
	}
	
	function getPlanArr() {
		$query = $this->db->get('plans');
		return $query->result_array();
	}
	
}
?>