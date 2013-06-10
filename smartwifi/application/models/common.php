<?php
Class Common extends CI_Model {
		
	function displayView($view) {
		$data['main_content'] = $view;
		$this->load->view('includes/template', $data);
	}
	
	function displayViewLogged($view, $data) {
		$is_logged_in = $this->session->userdata('is_logged_in');
		if($is_logged_in) {
			$data['main_content'] = $view;
			$this->load->view('includes/template', $data);
		}
		else {
   			$this->displayView('not_permitted');
		}
	}
}
?>