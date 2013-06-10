<?php
Class Campaigns_model extends CI_Model {
		
	function getCampaign() {
		$query = $this->db->get('campaigns');
		return $query->result();
	}
 
	function addCampaign($data) {
		
		$this->db->insert('campaigns', $data);
		
		$c_data['groupname'] = $data['name'];
		
		$hotspot_data = array(
					'hcampaign' => $data['name'],
					'assigned' => $data['client']);
					
		$h_data = explode(", ", $data['hotspots']);
		
		foreach ($h_data as $str) {
			$this->db->where('hname', $str);
			$this->db->update('hotspots', $hotspot_data);
		}
		
		
		$this->db->where('name', $data['plan']);
		$q = $this->db->get('plans');
		$p_data = $q->row();
		//insert into radgroupreply table.
		//max download speed
		if($p_data->bw_download != '') {
			$c_data['attribute']='WISPr-Bandwidth-Max-Down';
			$c_data['op']=':=';
			$c_data['value'] = $p_data->bw_download;
			
			$this->db->insert('radgroupreply',$c_data);
		}
		
		//max upload speed
		if($p_data->bw_upload != '') {
			$c_data['attribute']='WISPr-Bandwidth-Max-Up';
			$c_data['op']=':=';
			$c_data['value'] = $p_data->bw_upload;
			
			$this->db->insert('radgroupreply',$c_data);
		}
		
		//Maximum time - needed by both FreeRadius (at logon) and ChilliSpot (when logged on)
		if($p_data->type =='time'){
			$c_data['attribute']='Session-Timeout';
			$c_data['op']=':=';
			$c_data['value'] = $p_data->amount*60;
			
			$this->db->insert('radgroupcheck',$c_data);
			$this->db->insert('radgroupreply',$c_data);
		}
		
		//Duplicate the maximum packets needed by both FreeRadius (at logon) and ChilliSpot (when logged on) 
		if($p_data->type =='packet'){
			if ($this->config->item('access_controller') == 'chillispot-hc') {
				if ($p_data['amount'] >= 2048) { $p_data->amount = 2047; }
				$c_data['attribute']='ChilliSpot-Max-Total-Octets';
				$c_data['op']=':=';
				$c_data['value'] = $p_data->amount*1024*1024;
				$this->db->insert('radgroupcheck',$c_data);
				$this->db->insert('radgroupreply',$c_data);
			} elseif ($this->config->item('access_controller') == 'coovachilli') {
				$c_data['attribute']='Max-All-MB';
				$c_data['op']=':=';
				$c_data['value'] = $p_data->amount;
				$this->db->insert('radgroupcheck',$c_data);
				$c_data['attribute']='ChilliSpot-Max-Total-Gigawords';
				$c_data['op']=':=';
				$c_data['value'] = intval ($p_data->amount / 4096);
				$this->db->insert('radgroupreply',$c_data);
				// We must now use GMP (GNU Multiple Precision) because PHP doesn't use 
				// unsigned integers but coovachilli considers the ChilliSpot-Max-Total-Octets 
				// to be the bottom 32 bits of an unsigned 64 integer
				$c_data['attribute']='ChilliSpot-Max-Total-Octets';
				$c_data['op']=':=';
				$i = gmp_init ($p_data->amount);
				$i = gmp_mod ($i,4096 );
				$i = gmp_mul ($i, (1024 * 1024));
				$c_data['value'] = gmp_strval ($i);
				$this->db->insert('radgroupreply',$c_data);
			} else {
				if ($p_data->amount >= 2048) { $p_data->amount = 2047; }
				$c_data['attribute']='ChilliSpot-Max-Total-Octets';
				$c_data['op']=':=';
				$c_data['value'] = $p_data->amount*1024*1024;
				$this->db->insert('radgroupreply',$c_data);
				
				$c_data['attribute']='Max-All-MB';
				$c_data['op']=':=';
				$c_data['value'] = $p_data->amount;
				$this->db->insert('radgroupcheck',$c_data);
			}
		}
		
		//Idle-Timeout Currently same for all access_controllers
		if($p_data->IdleTimeout){
			$c_data['attribute'] = 'Idle-Timeout';
			$c_data['op'] = ':=';
			$c_data['value'] = $p_data->IdleTimeout*60;
			
			$this->db->insert('radgroupreply',$c_data);
		}

		// Acct-Interim-Interval Currently same for all access_controllers
		if($this->config->item('voucher_acct_interim_interval')){
			$c_data['attribute'] = 'Acct-Interim-Interval';
			$c_data['op'] = ':=';
			$c_data['value'] = $this->config->item('voucher_acct_interim_interval');
			
			$this->db->insert('radgroupreply',$c_data);
		}
		
		//Simultaneous-Use Currently same for all access_controllers
		$c_data['attribute'] = 'Simultaneous-Use';
		$c_data['op'] = ':=';
		$c_data['value'] = '1';
		$this->db->insert('radgroupcheck',$c_data);
		
		return;
	}
	
	function updateCampaign($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('campaigns', $data);
		
		$empty_campaign = array(
				'hcampaign' => ' ',
				'assigned' => ' ');
		$this->db->where('hcampaign', $data['name']);
		$this->db->update('hotspots', $empty_campaign);
		
		$hotspot_data = array(
					'hcampaign' => $data['name'],
					'assigned' => $data['client']);
					
		$h_data = explode(", ", $data['hotspots']);
		
		foreach($h_data as $str) {
			$this->db->where('hname', $str);
			$this->db->update('hotspots', $hotspot_data);
		}
		
	}
	
	function deleteCampaign(){
		$this->db->where('id', $this->uri->segment(3));
		$this->db->delete('campaigns');
	}
	
	function getCampArr() {
		$query = $this->db->get('campaigns');
		return $query->result_array();
	}
 
}
?>