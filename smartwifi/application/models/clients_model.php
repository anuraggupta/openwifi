<?php
Class Clients_model extends CI_Model {
		
	function getClient() {
		$query = $this->db->get('clients');
		return $query->result();
	}
 
	function addClient($data) {
		$this->db->insert('clients', $data);
		return;
	}
	
	function updateClient($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('clients', $data);
	}
	
	function deleteClient(){
		$this->db->where('id', $this->uri->segment(3));
		$this->db->delete('clients');
	}
	
	function getClientArr() {
		$query = $this->db->get('clients');
		return $query->result_array();
	}
 
}
?>