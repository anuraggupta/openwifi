<?php
	class Campaigns extends CI_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$data = array(); $i=1;
			$this->load->model('campaigns_model');
			$query = $this->campaigns_model->getCampaign();
			if($query)
			{
				$data['records'] = $query;
			}
			else {
				echo 'data error';
			}
			
			//get plans
			$this->load->model('plans_model');
			$plansquery = $this->plans_model->getPlanArr();
			$planNames = array();
			foreach ($plansquery as $row) {
			  $planNames[$row['name']] = $row['name'];
			}
			if($plansquery)
			{
				$data['plan_rec'] = $planNames;
			}
			else {
				$data['plan_rec'] = 'No plans found.';
			}
			
			//get hotspots
			$this->load->model('hotspots_model');
			$hotspotsquery = $this->hotspots_model->getHotspotArr();
			$hotspotNames = array();
			foreach ($hotspotsquery as $row) {
			  $hotspotNames[$row['hname']] = $row['hname'];
			}
			if($hotspotsquery)
			{
				$data['hotspots_rec'] = $hotspotNames;
			}
			else {
				$data['hotspots_rec'] = 'No hotspot found.';
			}
			
			//get clients
			$this->load->model('clients_model');
			$clientsquery = $this->clients_model->getClientArr();
			$clientNames = array();
			foreach ($clientsquery as $row) {
			  $clientNames[$row['cname']] = $row['cname'];
			}
			if($clientsquery)
			{
				$data['clients_rec'] = $clientNames;
			}
			else {
				$data['clients_rec'] = 'No hotspot found.';
			}
			
			
			
			$this->load->model('common');
   			$this->common->displayViewLogged('campaigns_view', $data);
		}
		
		function createCampaign() {
			
			//get plans
			$this->load->model('plans_model');
			$plansquery = $this->plans_model->getPlanArr();
			$planNames = array();
			foreach ($plansquery as $row) {
			  $planNames[$row['name']] = $row['name'];
			}
			if($plansquery)
			{
				$data['plan_rec'] = $planNames;
			}
			else {
				$data['plan_rec'] = 'No plans found.';
			}
			
			//get hotspots
			$this->load->model('hotspots_model');
			$hotspotsquery = $this->hotspots_model->getHotspotArr();
			$hotspotNames = array();
			foreach ($hotspotsquery as $row) {
			  $hotspotNames[$row['hname']] = $row['hname'];
			}
			if($hotspotsquery)
			{
				$data['hotspots_rec'] = $hotspotNames;
			}
			else {
				$data['hotspots_rec'] = 'No hotspot found.';
			}
			
			//get clients
			$this->load->model('clients_model');
			$clientsquery = $this->clients_model->getClientArr();
			$clientNames = array();
			foreach ($clientsquery as $row) {
			  $clientNames[$row['cname']] = $row['cname'];
			}
			if($clientsquery)
			{
				$data['clients_rec'] = $clientNames;
			}
			else {
				$data['clients_rec'] = 'No hotspot found.';
			}
			
			
			$this->load->model('common');
   			$this->common->displayViewLogged('campaigns_create', $data);
		}
		
		
		function create() {
			
			$hotspot_list = $this->input->post('campaignHotspots');
			$hlist = implode(", ", $hotspot_list);
			
			$data = array(
				'name' => $this->input->post('campaignName'),
				'client' => $this->input->post('campaignClient'),
				'details' => $this->input->post('campaignDetails'),
				'hotspots' => $hlist,
				'plan' => $this->input->post('campaignPlan'),
				'assurl' => $this->input->post('campaignURL'),
				'action' => $this->input->post('campaignAction'),
				'startdate' => $this->input->post('campaignStart'),
				'enddate' => $this->input->post('campaignEnd'),
			);
			
			$this->load->model('campaigns_model');
			$this->campaigns_model->addCampaign($data);
			
		}
		
		function update() {
			
			$hotspot_list = $this->input->post('campaignHotspots');
			$hlist = implode(", ", $hotspot_list);
			
			$data = array(
				'id' => $this->input->post('campaignId'),
				'name' => $this->input->post('campaignName'),
				'client' => $this->input->post('campaignClient'),
				'details' => $this->input->post('campaignDetails'),
				'hotspots' => $hlist,
				'plan' => $this->input->post('campaignPlan'),
				'action' => $this->input->post('campaignAction'),
				'assurl' => $this->input->post('campaignURL'),
				'startdate' => $this->input->post('campaignStart'),
				'enddate' => $this->input->post('campaignEnd'),
			);
			
			$this->load->model('campaigns_model');
			$this->campaigns_model->updateCampaign($data);
			
		}
		
		
		function delete() {
			$this->load->model('campaigns_model');
			$this->campaigns_model->deleteCampaign();
			$this->index();
		}
		
	}
?>