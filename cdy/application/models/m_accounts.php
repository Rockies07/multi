<?php
Class m_Accounts extends CI_Model
{
	function login($username, $password, $account_type, $account_db)
	{
		$this -> db -> select($account_db,' password');
		$this -> db -> from($account_type);
		$this -> db -> where($account_db, $username);
		$this -> db -> where('password', $password);
		$this -> db -> where('type', 'sub');
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	function getintake($uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
		}

		$sql = "SELECT intake_big, intake_small,intake_tax,placeout_com FROM $account_db WHERE $account_type = ?"; 
		$query = $this->db->query($sql, array($uid)); 

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getinfo($uid)
	{
		switch(strlen($uid))
		{
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}

		$sql = "SELECT * FROM $account_db WHERE $account_type = ? and status = 'active'"; 
		$query = $this->db->query($sql, array($uid)); 
		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function changepass($uid, $password)
	{
		$sql = "update users_adm set password = ? WHERE adm_id = ?"; 
		$query = $this->db->query($sql, array($password,$uid));
	}

	function get_smsinbox($uid)
	{
		$sql = "SELECT * FROM sms_manual WHERE assign = ? and reply_status = 'N'"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}
		return $result;
	}

	function get_smsmsg($id)
	{
		$sql = "SELECT * FROM sms_manual WHERE id = ?"; 
		$query = $this->db->query($sql, array($id)); 
		foreach ($query->result_array() as $row)
		{
			$result = $row;
		}
		return $result;
	}

	function get_smsincoming()
	{
		$sql = "SELECT * FROM sms_manual WHERE assign = '' and reply_status = 'N'"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}
		return $result;
	}

	function get_smssent($filter_id,$filter_date)
	{
		if($filter_id!="")
		{	
			$filter_text=" AND meb_id like '%$filter_id%'";
		}
		
		if($filter_date!="")
		{	
			$filter_text .=" AND datetime like '%$filter_date%'";
		}
		
		$sql = "SELECT * FROM sms_manual WHERE reply_status = 'Y' $filter_text order by meb_id asc"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}
		return $result;
	}

	function sms_mark_reply($sms_id, $msg)
	{
		$sql = "update sms_manual set reply_status = 'Y', reply_msg = ? WHERE id = ?"; 
		$query = $this->db->query($sql, array($msg,$sms_id));
	}

	function assign_sms($uid, $sms_id)
	{
		$sql = "update sms_manual set assign = ? WHERE id = ? and reply_status = 'N' and assign = ''"; 
		$query = $this->db->query($sql, array($uid,$sms_id));
	}

	function unassign_sms($uid, $sms_id)
	{
		$sql = "update sms_manual set assign = '' WHERE id = ? and assign = ? and reply_status = 'N'"; 
		$query = $this->db->query($sql, array($sms_id,$uid));
	}
	
	function unassign_sms_toinbox($uid, $sms_id)
	{
		$sql = "update sms_manual set reply_status = 'N' WHERE id = ? and assign = ? and reply_status = 'Y'"; 
		$query = $this->db->query($sql, array($sms_id,$uid));
	}
	
	function get_smstrash($filter_id, $filter_date)
	{
		if($filter_id!="")
		{	
			$filter_text=" AND meb_id like '%$filter_id%'";
		}
		
		if($filter_date!="")
		{	
			$filter_text .=" AND datetime like '%$filter_date%'";
		}
		
		$sql = "SELECT * FROM sms_manual WHERE reply_status = 'D' $filter_text order by meb_id asc"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}
		return $result;
	}
	function get_smstrash_filter($meb_id, $drawdate)
	{
		if (strlen($meb_id) == 0)
		{
			$sql = "SELECT * FROM sms_manual WHERE reply_status = 'D' and DATE(datetime) = ? order by datetime asc"; 
			$query = $this->db->query($sql, array($drawdate)); 
		}
		else
		{
			$sql = "SELECT * FROM sms_manual WHERE reply_status = 'D' and meb_id = ? and DATE(datetime) = ? order by datetime asc"; 
			$query = $this->db->query($sql, array($meb_id, $drawdate)); 
		}
	
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$result[$x] = $row;
			$x = $x + 1;
		}
		return $result;
	}

	function assign_smstrash($sms_id)
	{
		$sql = "update sms_manual set reply_status = 'D' WHERE id = ?"; 
		$query = $this->db->query($sql, array($sms_id));
	}

	
	function unassign_smstrash($sms_id, $uid)
	{
		$sql = "update sms_manual set reply_status = 'N', assign = ? WHERE id = ? and reply_status = 'D'"; 
		$query = $this->db->query($sql, array($uid, $sms_id));
	}

	function getdownlinedata_man($uid)
	{
		$this->db->select('mas_id');
		$this->db->select('name');
		$this->db->where("status", 'active');
		$this->db->not_like('mas_id','--');
		$this->db->order_by("mas_id", "asc"); 
		$query = $this->db->get('users_mas');
		
		$data = array();
		$data['#'] = '-- Select Downline --';
		foreach ($query->result_array() as $row)
		{
		   $data[$row['mas_id']] = $row['mas_id']." ( ".$row['name']." )";
		}
		return $data;
	}
	
	function get_all_mas($uid)
	{
		$this->db->select('mas_id');
		$this->db->select('name');
		$this->db->where("status", 'active');
		$this->db->not_like('mas_id','--');
		$this->db->order_by("mas_id", "asc"); 
		$query = $this->db->get('users_mas');
		
		$data = array();
		$data['#'] = '-- Select Downline --';
		foreach ($query->result_array() as $row)
		{
		   $data[$row['mas_id']] = $row['mas_id']." ( ".$row['name']." )";
		}
		return $data;
	}

	function getmebdata($uid)
	{

		$this->db->select('meb_id, name');
		$this->db->where("mas_id", $uid); 
		$this->db->where("status", 'active'); 
		$this->db->not_like('meb_id','--');
		$this->db->order_by('meb_id', "asc"); 		

		$query = $this->db->get('users_meb');
		
		$data = array();
		//$data['#'] = '--- Select Member ---';

		foreach ($query->result_array() as $row)
		{
		   $data[$row['meb_id']] = $row['meb_id']." ( ".$row['name']." )";
		}
		return $data;
	}
	function update_member_balance($amt, $uid)
	{
		$this->db->set('balance', 'balance - '.$amt, FALSE);
		$this->db->where('meb_id', $uid);
		$this->db->update('users_meb'); 
	}

	
	function getdownline($uid)
	{
		switch(strlen($uid))
		{
			case 3: $downline_table = "users_mas";
					$downline_type = "mas_id";
					$account_type = "man_id";
					break;			
			case 2: $downline_table = "users_agg";
					$downline_type = "agg_id";
					$account_type = "mas_id";
					break;
			case 4: $downline_table = "users_agt";
					$downline_type = "agt_id";
					$account_type = "agg_id";
					break;
			case 6: $downline_table = "users_meb";
					$downline_type = "meb_id";
					$account_type = "agt_id";
					break;
		}

		$sql = "SELECT * FROM $downline_table WHERE $account_type = ? order by $downline_type asc"; 
		$query = $this->db->query($sql, array($uid)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}
	
	function getdownlinetype($uid)
	{
		switch(strlen($uid))
		{
			case 3: $downline_type = "mas_id";
					break;
			case 2: $downline_type = "agg_id";
					break;
			case 4: $downline_type = "agt_id";
					break;
			case 6: $downline_type = "meb_id";
					break;
		}

		return $downline_type;
	}

	function getbetrecords($fromdate,$todate,$uid,$sort="")
	{
		if($sort!="")
		{
			if(strtoupper($sort)!="NORMAL")
				$sql_filter_sort="and pageref like '$sort-%'";
			else 
				$sql_filter_sort="and pageref not like 'FIX-%' and pageref not like 'MOB-%' and pageref not like 'TXT-%' and pageref not like 'SMS-%'";
		}
		
		switch(strlen($uid))
		{
			case 2: $account_type = "mas_id";
					break;
			case 4: $account_type = "agg_id";
					break;
			case 6: $account_type = "agt_id";
					break;
			case 8: $account_type = "meb_id";
					break;
		}

		$sql = "SELECT * FROM bet_records WHERE $account_type = ? and drawdate >= ? and drawdate <= ? $sql_filter_sort order by meb_id,drawdate,entrytime asc"; 
		$query = $this->db->query($sql, array($uid, $fromdate, $todate)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}

	function get_page_ref($ref)
	{

		$sql = "SELECT pageref FROM bet_records WHERE ref = ? "; 
		$query = $this->db->query($sql, array($ref)); 

		foreach ($query->result_array() as $row)
		{
		   return $row['pageref'];
		}	
	}
	
	function getpagedetails($ref,$drawdate)
	{
		$sql = "SELECT * FROM page_details WHERE ref = ? and drawdate = ? order by numinpage asc"; 
		$query = $this->db->query($sql, array($ref, $drawdate)); 
		$x = 1;
		foreach ($query->result_array() as $row)
		{
			$results[$x] = $row;
			$x = $x + 1;
		}
		return $results;
	}


	function getbetrecords_ref($ref,$drawdate)
	{

		$sql = "SELECT * FROM bet_records WHERE ref = ? and drawdate = ? "; 
		$query = $this->db->query($sql, array($ref, $drawdate)); 

		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}

	function getbetrecords_table($ref,$drawdate)
	{

		$sql = "SELECT ceil(count(*)/80) as count FROM page_details WHERE ref = ? and drawdate = ? "; 
		$query = $this->db->query($sql, array($ref, $drawdate)); 

		foreach ($query->result_array() as $row)
		{
		   return $row['count'];
		}	
	}

	function getinfo2($uid)
	{
		switch(strlen($uid))
		{
			case 3: $account_db = "users_man";
					$account_type = "man_id";
					break;			
			case 2: $account_db = "users_mas";
					$account_type = "mas_id";
					break;
			case 4: $account_db = "users_agg";
					$account_type = "agg_id";
					break;
			case 6: $account_db = "users_agt";
					$account_type = "agt_id";
					break;
			case 8: $account_db = "users_meb";
					$account_type = "meb_id";
					break;
		}

		$sql = "SELECT * FROM $account_db WHERE $account_type = ?"; 
		$query = $this->db->query($sql, array($uid)); 
		foreach ($query->result_array() as $row)
		{
		   return $row;
		}	
	}	
	function get_trans_records($fromdate,$number)
	{
		$sql = "SELECT * FROM transactions WHERE drawdate = ? and number = ? order by meb_id, drawdate asc"; 
		$query = $this->db->query($sql, array($fromdate, $number)); 
		$x = 1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$results[$x] = $row;
				$x = $x + 1;
			}
			return $results;
		}
	}	
	function getfixpagedata($uid,$pageref)
	{
		$sql = "SELECT number,cmd,amt_big,amt_small,numinpage FROM transactions_fix WHERE meb_id = ? and pageref = ? order by numinpage asc"; 
		$query = $this->db->query($sql, array($uid,$pageref)); 
		
		foreach ($query->result_array() as $row)
		{
		   $data[] = array('number' => $row['number'],
						'cmd' => $row['cmd'],
						'amt_big' => $row['amt_big'],
						'amt_small' => $row['amt_small'],
						'numinpage' => $row['numinpage'],
						);
		}
		return $data;
	}
	function getfixpage($uid)
	{
		$sql = "SELECT distinct(pageref) FROM transactions_fix WHERE meb_id = ?"; 
		$query = $this->db->query($sql, array($uid)); 
		
		$data[''] = '-- Add New Page --';

		foreach ($query->result_array() as $row)
		{
		   $data[$row['pageref']] = $row['pageref'];
		}
		return $data;
	}
	function get_fixpage_count($uid,$page)
	{

		$sql = "SELECT count(*) as count FROM transactions_fix WHERE pageref = ? and meb_id = ? "; 
		$query = $this->db->query($sql, array($page, $uid)); 

		foreach ($query->result_array() as $row)
		{
		   return $row['count'];
		}	
	}	
	function delfixpagedata($uid,$pageref)
	{
		$sql = "DELETE FROM transactions_fix WHERE meb_id = ? and pageref = ?"; 
		$query = $this->db->query($sql, array($uid,$pageref)); 
	}	
}
?>