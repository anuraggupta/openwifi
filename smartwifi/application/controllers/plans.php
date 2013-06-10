<?php
	class Plans extends CI_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$data = array(); $i=1;
			$this->load->model('plans_model');
			$query = $this->plans_model->getPlan();
			
			if($query)
			{
				$data['records'] = $query;
			}
			else {
				echo 'data error';
			}
			
			$this->load->model('common');
   			$this->common->displayViewLogged('plans_view', $data);
		}
		
		function createPlan() {
			$this->load->model('common');
   			$this->common->displayViewLogged('plans_create', '');
		}
		
		
		function create() {
			
			$data = array(
				'name' => $this->input->post('planName'),
				'type' => $this->input->post('planType'),
				'amount' => $this->input->post('planAmount'),
				'price' => $this->input->post('planPrice'),
				'bw_download' => $this->input->post('planDown'),
				'bw_upload' => $this->input->post('planUp'),
				'IdleTimeout' => $this->input->post('planTimeout'),
			);
			
			$this->load->model('plans_model');
			$this->plans_model->addPlan($data);
			
		}
		
		function update() {
			$data = array(
				'id' => $this->input->post('planId'),
				'name' => $this->input->post('planName'),
				'type' => $this->input->post('planType'),
				'amount' => $this->input->post('planAmount'),
				'price' => $this->input->post('planPrice'),
				'bw_download' => $this->input->post('planDown'),
				'bw_upload' => $this->input->post('planUp'),
				'IdleTimeout' => $this->input->post('planTimeout'),
			);
			
			$this->load->model('plans_model');
			$this->plans_model->updatePlan($data);
			
		}
		
		
		function delete() {
			$this->load->model('plans_model');
			$this->plans_model->deletePlan();
			$this->index();
		}
		
	}
?>