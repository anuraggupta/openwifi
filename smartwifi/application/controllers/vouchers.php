<?php
	class Vouchers extends CI_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$data = array(); $i=1;
			
			//get campaign
			$this->load->model('campaigns_model');
			$campquery = $this->campaigns_model->getCampArr();
			$campNames = array();
			foreach ($campquery as $row) {
			  $campNames[$row['name']] = $row['name'];
			}
			if($campquery)
			{
				$data['camp_rec'] = $campNames;
			}
			else {
				$data['camp_rec'] = 'No campaigns.';
			}
			
			
			$this->load->model('common');
   			$this->common->displayViewLogged('vouchers_view', $data);
		}
		
		function getCampVouchers() {
			$data = array();
			$camp = $this->input->post('selectedCamp');
			$this->load->model('vouchers_model');
			$query = $this->vouchers_model->getVoucher($camp);
			if($query)
			{
				$data['records'] = $query;
			}
			else {
				$data['records'] = 'No Vouchers found under this campaign.';
			}
			
			echo json_encode($data);
		}
		
		function createVouchers() {
			
			//get campaign
			$this->load->model('campaigns_model');
			$campquery = $this->campaigns_model->getCampArr();
			$campNames = array();
			foreach ($campquery as $row) {
			  $campNames[$row['name']] = $row['name'];
			}
			if($campquery)
			{
				$data['camp_rec'] = $campNames;
			}
			else {
				$data['camp_rec'] = 'No Campaigns found.';
			}
			
			
			$this->load->model('common');
   			$this->common->displayViewLogged('vouchers_create', $data);
		}
		
		
		function create() {
			
			$data = array(
				'voucherCamp' => $this->input->post('voucherCamp'),
				'voucherQty' => $this->input->post('voucherQty'),
			);
			
			$this->load->model('vouchers_model');
			$voucherquery = $this->vouchers_model->addVoucher($data);
			
			echo json_encode($voucherquery);
		}
		
		function update() {
			
			$data = array(
				'id' => $this->input->post('voucherId'),
				'username' => $this->input->post('voucherUsername'),
				'password' => $this->input->post('voucherPass'),
				'campaign' => $this->input->post('voucherCampaign'),
			);
			
			$this->load->model('vouchers_model');
			$this->vouchers_model->updateVoucher($data);
			
		}
		
		
		function delete() {
			$this->load->model('vouchers_model');
			$this->vouchers_model->deleteVoucher();
			$this->index();
		}
		
	}
?>