<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Clients extends CI_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$data = array(); $i=1;
			$this->load->model('clients_model');
			$query = $this->clients_model->getClient();
			
			if($query)
			{
				$data['records'] = $query;
			}
			else {
				echo 'data error';
			}
			
			$this->load->model('common');
   			$this->common->displayViewLogged('clients', $data);
		}
		
		function createClient() {
			$this->load->model('common');
   			$this->common->displayViewLogged('clients_create', '');
		}
		
		
		function create() {
			
			$data = array(
				'cname' => $this->input->post('clientName'),
				'contact' => $this->input->post('clientContact'),
				'email' => $this->input->post('clientEmail'),
				'defurl' => $this->input->post('clientURL'),
				'comments' => $this->input->post('comments')
			);
			
			$this->load->model('clients_model');
			$this->clients_model->addClient($data);
			
        	echo json_encode($data);
		}
		
		function update() {
			$data = array(
				'id' =>  $this->input->post('clientId'),
				'cname' => $this->input->post('clientName'),
				'contact' => $this->input->post('clientContact'),
				'email' => $this->input->post('clientEmail'),
				'defurl' => $this->input->post('clientURL'),
				'comments' => $this->input->post('comments')	
			);
			
			$this->load->model('clients_model');
			$this->clients_model->updateClient($data);
			
		}
		
		
		function delete() {
			$this->load->model('clients_model');
			$this->clients_model->deleteClient();
			$this->index();
		}
		
	}
?>