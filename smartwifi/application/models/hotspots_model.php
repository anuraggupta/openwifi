<?php
Class Hotspots_model extends CI_Model {
		
	function getHotspot() {
		$query = $this->db->get('hotspots');
		return $query->result();
	}
 
	function addHotspot($data) {
		$this->db->insert('hotspots', $data);
		return;
	}
	
	function updateHotspot($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('hotspots', $data);
	}
	
	function deleteHotspot(){
		$this->db->where('id', $this->uri->segment(3));
		$this->db->delete('hotspots');
	}
	
	function getHotspotArr() {
		$query = $this->db->get('hotspots');
		return $query->result_array();
	}
 
}
?>