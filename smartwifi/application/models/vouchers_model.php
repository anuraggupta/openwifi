<?php
Class Vouchers_model extends CI_Model {
		
	function getVoucher($data) {
		$this->db->where('campaign', $data);
		$query = $this->db->get('voucher_list');
		return $query->result();
	}
 
	function addVoucher($data) {
		
		$res =0;
		$camp_name = $data['voucherCamp'];
		$numberofvoucher = $data['voucherQty'];
		
		//getting campaign details
		$this->db->where('name', $camp_name);
		$q1 = $this->db->get('campaigns');
		$camp_data = $q1->row();
		$plan_name = $camp_data->plan;
		
		//getting plan details
		$this->db->where('name', $plan_name);
		$q2 = $this->db->get('plans');
		$plan_data = $q2->row();
		
		//calculation of number of valid days left in campaign
		$curr_date = time();
		$ending=strtotime($camp_data->enddate);
		$date_diff= $ending - $curr_date;
		$valid_for = floor($date_diff/(60*60*24))+1;
		$this->load->helper('randomuser');
		
		if($valid_for>0)	{
			//insert to database
			for($i=0;$i<$numberofvoucher;$i++) {
				
				$user = generate_random_user();
				$groupname = $camp_name;
				$value = $plan_data->amount;
				
				if($this->vouchers_model->VoucherExist($user['username'])){		//check username for duplication 
					$i--; //repeat the step
					continue;
				}
				else {
					//Ensuring accurate database insertions
					$this->db->trans_start();
					
					//Voucher table
					$voucher = array('username'=>$user['username'],'password'=>$user['password'],'campaign'=>$groupname);
					$this->db->insert('vouchers',$voucher);
				
					//usergroup table
					$usergroup = array('username'=>$user['username'],'groupname'=>$groupname,'priority'=>'1');
					$this->db->insert('radusergroup',$usergroup);
					
					//radcheck table
					$radcheck = array('username'=>$user['username'],'attribute'=>'Cleartext-Password','op'=>':=','value'=>$user['password']);
					$this->db->insert('radcheck',$radcheck);
					
					//Expiration with format = November 28 2007 20:26:43
					$month = date('F');
					$day = date('j');
					$year = date('Y');
					$time = '24:00:00';
					
					$date = mktime(0,0,0, date('m'), $day+$valid_for, $year);
					
					$date = date("F j Y", $date)." ".$time;
					$radcheck = array('username'=>$user['username'],'attribute'=>'Expiration','op'=>':=','value'=>$date);
					$this->db->insert('radcheck',$radcheck);
					
					//OK stop here
					$this->db->trans_complete();
				}
			}
			$res=1;
		}
		else {
			$res=0;
		}
		
		return $res;
	}
	
	function updateVoucher($data) {
		
		//Start transaction
		$this->db->trans_start();
		
		//Voucher table
		$voucher_change = array('password'=>$data['password'],'campaign'=>$data['campaign']);
		$this->db->where('username',$data['username']);
		$this->db->update('vouchers',$voucher_change);
		
		//Radcheck table
		$radcheck_change = array('value'=>$data['password']);
		$this->db->where('username',$data['username']);
		$this->db->update('radcheck',$radcheck_change);
		
		//Usergroup table
		$usergroup_change = array('groupname' => $data['campaign']);
		$this->db->where('username',$data['username']);
		$this->db->update('radusergroup',$usergroup_change);
		
		//OK stops here
		$this->db->trans_complete();
		
	}
	
	function deleteVoucher(){
		
		//Start transaction
		$this->db->trans_start();
						
		//Voucher table
		$this->db->where('username',$this->uri->segment(3));
		$this->db->delete('vouchers');
			
		//usergroup table
		$this->db->where('username',$this->uri->segment(3));
		$this->db->delete('radusergroup');
				
		//radcheck table
		$this->db->where('username',$this->uri->segment(3));
		$this->db->delete('radcheck');
				
		//OK stops here
		$this->db->trans_complete();
		
	}
	
	function getVoucherArr() {
		$query = $this->db->get('voucher_list');
		return $query->result_array();
	}
	
	function VoucherExist($username){
		$this->db->where('username',$username);
		$query = $this->db->get('vouchers');
		
		if($query->num_rows > 0)
			return true;
		else 
			return false;
	}
 
}
?>