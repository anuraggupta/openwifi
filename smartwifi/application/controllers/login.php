<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   $this->load->model('common');
   $this->common->displayView('login_view');
 }
 
 function validateCredentials() {
 	$this->load->model('user');
	$query = $this->user->validate();
	
	if($query) {     //User credential verified...
		$data = array (
			'username' => $this->input->post('username'),
			'is_logged_in' => true
		);
		
		$this->session->set_userdata($data);
		redirect('home/loginarea');
	}
	else {
		$this->index();
	}
 }
}
?>