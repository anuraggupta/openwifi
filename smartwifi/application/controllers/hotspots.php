<?php
	class Hotspots extends CI_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$data = array(); $i=1;
			$this->load->model('hotspots_model');
			$query = $this->hotspots_model->getHotspot();
			if($query)
			{
				$data['records'] = $query;
			}
			else {
				echo 'data error';
			}
			
			$this->load->model('plans_model');
			$query2 = $this->plans_model->getPlanArr();
			$planNames = array();
			foreach ($query2 as $row) {
			  $planNames[$row['name']] = $row['name'];
			}
			if($query2)
			{
				$data['plan_rec'] = $planNames;
			}
			else {
				$data['plan_rec'] = 'No plans found.';
			}
			
			
			$this->load->model('common');
   			$this->common->displayViewLogged('hotspot_view', $data);
		}
		
		function createHotspot() {
			$this->load->model('plans_model');
			$query = $this->plans_model->getPlanArr();
			$planNames = array();
			foreach ($query as $row) {
			  $planNames[$row['name']] = $row['name'];
			}
			$data['plan_rec'] = $planNames;
			
			$this->load->model('common');
   			$this->common->displayViewLogged('hotspot_create', $data);
		}
		
		
		function create() {
			
			$unique= substr($this->input->post('hotspotMac'), 0, 4).substr($this->input->post('hotspotInumber'), 0, 4);
			
			
			$data = array(
				'hname' => $this->input->post('hotspotName'),
				'router' => $this->input->post('hotspotRouter'),
				'outlet' => $this->input->post('hotspotOutlet'),
				'add' => $this->input->post('hotspotAdd'),
				'location' => $this->input->post('hotspotLoc'),
				'hdefurl' => $this->input->post('hotspotURL'),
				'macadd' => $this->input->post('hotspotMac'),
				'operator' => $this->input->post('hotspotOperator'),
				'inumber' => $this->input->post('hotspotInumber'),
				'uniqueid' => $unique,
			);
			
			$this->load->model('hotspots_model');
			$this->hotspots_model->addHotspot($data);
		}
		
		function update() {
			$data = array(
				'id' =>  $this->input->post('hotspotId'),
				'hname' => $this->input->post('hotspotName'),
				'router' => $this->input->post('hotspotRouter'),
				'outlet' => $this->input->post('hotspotOutlet'),
				'add' => $this->input->post('hotspotAdd'),
				'location' => $this->input->post('hotspotLoc'),
				'hdefurl' => $this->input->post('hotspotURL'),
				'macadd' => $this->input->post('hotspotMac'),
				'operator' => $this->input->post('hotspotOperator'),
				'inumber' => $this->input->post('hotspotInumber'),
					
			);
			
			$this->load->model('hotspots_model');
			$this->hotspots_model->updateHotspot($data);
			
		}
		
		
		function delete() {
			$this->load->model('hotspots_model');
			$this->hotspots_model->deleteHotspot();
			$this->index();
		}
		
	}
?>