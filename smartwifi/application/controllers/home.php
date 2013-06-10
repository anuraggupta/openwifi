<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Home extends CI_Controller {
		
		function __construct() {
			parent::__construct();
			$this->is_logged_in();
		}
		
		function loginarea() {
			$this->load->model('common');
   			$this->common->displayViewLogged('home', '');
		}
		
		function is_logged_in() {
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if(!isset($is_logged_in) || $is_logged_in != true) {
				$this->load->model('common');
   				$this->common->displayView('not_permitted');
			}
		}
		
		function logout() {
		   $this->session->unset_userdata('is_logged_in');
		   redirect('home/loginarea', 'refresh');
		 }
		
	}
?>